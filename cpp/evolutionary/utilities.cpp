#include "utilities.hpp"

float norme2(float x1, float y1, float x2, float y2) {
    return std::sqrt(std::pow(x2 - x1, 2) + std::pow(y2 - y1, 2));
}

PunkObject::PunkObject(float _x, float _y, float _mass) {
    x = _x;
    y = _y;
    
    mass = _mass;
};

void PunkObject::process(float delta) {
    vy += 9.8;

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
        if (*this != a) {
            float overlap = total_mass - distance;
            float x_pushback = (x - a.x) / distance;
            float y_pushback = (y - a.y) / distance;

            //std::cout << overlap << " " << x_pushback << " " << y_pushback << std::endl;

            // Position
            nx += x_pushback * overlap * (a.mass/total_mass);
            ny += y_pushback * overlap * (a.mass/total_mass);

            // Velocity
            try_bounce(x_pushback, y_pushback, a.vx, a.vy, a.mass, first_substep);
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

std::vector<float> PunkObject::record() {
    return {x, y, mass};
}
