#include "utilities.hpp"

float norme2(float x1, float y1, float x2, float y2) {
    return std::sqrt(std::pow(x2 - x1, 2) + std::pow(y2 - y1, 2));
}

uint64_t random64() {
  uint64_t r = 0;
  for (int i=0; i<64; i += 15 /*30*/) {
    r = r*((uint64_t)RAND_MAX + 1) + rand();
  }
  return r;
}

int random(int max, int buffer) {
    return (rand() % max) + buffer;
}

PunkObject::PunkObject(float _x, float _y, float _mass) {
    x = _x;
    y = _y;
    
    mass = _mass;
};

void PunkObject::process(float delta) {
    vy += 9.8;

    vx *= 0.98;
    vy *= 0.98;

    x += vx * delta;
    y += vy * delta;
}

float PunkObject::distance_to(const PunkObject a) {
    return norme2(x, y, a.x, a.y);
}

void PunkObject::solve_collision(const PunkObject a, bool first_substep) {
    float distance = distance_to(a);
    float total_mass = mass + a.mass;

    // Other Punk Objects
    if (distance < total_mass) {
        if (*this != a && !connected_to(a)) {
            float overlap = total_mass - distance;
            float x_pushback = (x - a.x) / distance;
            float y_pushback = (y - a.y) / distance;

            //std::cout << overlap << " " << x_pushback << " " << y_pushback << std::endl;

            // Position
            nx += x_pushback * overlap * (a.mass/total_mass);
            ny += y_pushback * overlap * (a.mass/total_mass);

            // Velocity
            try_bounce(x_pushback, y_pushback, a.vx, a.vy, a.mass, first_substep);

            //std::cout << "collision" << std::endl;
        }
    }

    // Border
    // -- Corners
    if (x < mass && y < mass) {
        nx = mass;
        ny = mass;
        try_bounce(1, 1, 0, 0, 10, first_substep);
    }
    else if (x < mass && y > 900 - mass) {
        nx = mass;
        ny = 900 - mass;
        try_bounce(1, -1, 0, 0, 10, first_substep);
    }
    else if (x > 900 - mass && y < mass) {
        nx = 900 - mass;
        ny = mass;
        try_bounce(-1, 1, 0, 0, 10, first_substep);
    }
    else if (x > 900 - mass && y > 900 - mass) {
        nx = 900 - mass;
        ny = 900 - mass;
        try_bounce(-1, -1, 0, 0, 10, first_substep);
    }
    // -- Walls
    else if (x < mass) {
        nx = mass;
        try_bounce(1, 0, 0, 0, 10, first_substep);
    }
    else if (y < mass) {
        ny = mass;
        try_bounce(0, 1, 0, 0, 10, first_substep);
    }
    else if (x > 900 - mass) {
        nx = 900 - mass;
        try_bounce(-1, 0, 0, 0, 10, first_substep);
    }
    else if (y > 900 - mass) {
        ny = 900 - mass;
        try_bounce(0, -1, 0, 0, 10, first_substep);
    }
}

void PunkObject::solve_collisions(const std::vector<PunkObject>& list, bool first_substep) {
    nx = x;
    ny = y;

    nvx = vx;
    nvy = vy;

    for (int i = 0; i < list.size(); i++) {
        solve_collision(list[i], first_substep);
    }
}

void PunkObject::establish() {
    x = nx;
    y = ny;

    vx = nvx;
    vy = nvy;
};

void PunkObject::try_bounce(float x_normal, float y_normal, float collider_speed_x, float collider_speed_y, float collider_mass, bool first_substep) {
    //std::cout << print_position() << std::endl;
    if (first_substep) { bounce(x_normal, y_normal, collider_speed_x, collider_speed_y, collider_mass); }
}

void PunkObject::bounce(float x_normal, float y_normal, float collider_speed_x, float collider_speed_y, float collider_mass) {
    /*
    float speed = norme2(0, 0, vx, vy);
    
    float x_bounce = x_normal + (vx/speed);
    float y_bounce = y_normal + (vy/speed);

    float bounce = norme2(0, 0, x_bounce, y_bounce);

    if (bounce > 0.01) {
        x_bounce /= bounce;
        y_bounce /= bounce;

        vx = x_bounce * bouncyness * speed;
        vy = y_bounce * bouncyness * speed;
    } else {
        vx = -vx * bouncyness * speed;
        vy = -vy * bouncyness * speed;
    }
    */
    
    // std::cout << vx << ", " << vy << std::endl;

    float dot_normal_v = vx * x_normal + vy * y_normal;
    nvx = vx - (2 * dot_normal_v * x_normal);
    nvy = vy - (2 * dot_normal_v * y_normal);

    float speed = norme2(0, 0, vx, vy);
    float collider_speed = norme2(0, 0, collider_speed_x, collider_speed_y);
    float new_v = (bouncyness * collider_mass * (collider_speed - speed) + (mass * speed) + (collider_mass * collider_speed))/(mass + collider_mass);
    
    nvx = nvx/speed * new_v;
    nvy = nvy/speed * new_v;
    // std::cout << vx << ", " << vy << std::endl;
}

void PunkObject::connect(PunkObject* a) {
    connexions.push_back(a);
    for (int i = 0; i < connexions.size(); i++) {
        if (!connexions[i]->connected_to(*a)) {connexions[i]->connect(a);}
    }
}

bool PunkObject::connected_to(PunkObject a) {
    for (int i = 0; i < connexions.size(); i++) {
        if (a == *connexions[i]) {
            return true;
        }
    }
    return false;
}

std::vector<float> PunkObject::record() {
    return {x, y, mass};
}

PunkJoint::PunkJoint(PunkObject* _object1, PunkObject* _object2, float _distance) {
    std::cout << "test4" << std::endl;
    object1 = _object1;
    object2 = _object2;
    distance = _distance;

    if (!object1->connected_to(*object2)) {object1->connect(object2);}
    if (!object2->connected_to(*object1)) {object2->connect(object1);}
}

void PunkJoint::process() {
    /*
    float x_axis = object1->x - object2->x;
    float y_axis = object1->y - object2->y;

    float actual_distance = norme2(x_axis, y_axis, 0, 0);
    
    float x_multiplier = x_axis / actual_distance;
    float y_multiplier = y_axis / actual_distance;

    float delta = distance - actual_distance;

    object1->nx += 0.5 * delta * x_multiplier;
    object1->ny += 0.5 * delta * y_multiplier;
    object2->nx += 0.5 * delta * x_multiplier;
    object2->ny += 0.5 * delta * y_multiplier;

    //std::cout << object1->vx << " " << object1->y << std::endl;

    */

    float x_axis = object1->x - object2->x;
    float y_axis = object1->y - object2->y;

    float actual_distance = norme2(object1->x, object1->y, object2->x, object2->y);

    float x_normalized = x_axis / actual_distance;
    float y_normalized = y_axis / actual_distance;

    float delta = distance - actual_distance;

    if (std::abs(delta) > 0.1) {
        object1->nx += 0.5 * delta * x_normalized;
        object1->ny += 0.5 * delta * y_normalized;
        object2->nx -= 0.5 * delta * x_normalized;
        object2->ny -= 0.5 * delta * y_normalized;
    }
}

std::vector<float> PunkJoint::record() {
    return {object1->x, object1->y, object2->x, object2->y, object1->mass, object2->mass};
}