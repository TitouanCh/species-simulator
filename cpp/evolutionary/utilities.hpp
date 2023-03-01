#include <vector>
#include <string>
#include <functional>
#include <cmath>

#include <iostream>

float norme2(float x1, float y1, float x2, float y2);

struct PunkObject
{
    float x = 0;
    float y = 0;

    float vx = 0;
    float vy = 0;

    float nx = 0;
    float ny = 0;

    float nvx = 0;
    float nvy = 0;

    float mass = 10;
    float bouncyness = 0.5;

    const std::function<float(float, float, float, float)> norme = norme2;

    PunkObject(float _x, float _y, float _mass);

    void process(float delta);

    float distance_to(const PunkObject a);

    void solve_collision(const PunkObject a, bool fist_substep);

    void solve_collisions(const std::vector<PunkObject>& list, bool first_substep);

    void establish();

    void try_bounce(float x_normal, float y_normal, float collider_speed_x, float collider_speed_y, float collider_mass, bool first_substep);

    void bounce(float x_normal, float y_normal, float collider_speed_x, float collider_speed_y, float collider_mass);
    
    std::vector<float> record();

    // Operators
    inline bool operator==(const PunkObject a) {
       if (a.x == x && a.y == y && a.mass == mass) {
            return true;
       }
       return false;
    }

    inline bool operator!=(const PunkObject a) {
        return !(*this == a);
    }

    // Debug
    std::string print_position() {
        return "[" + std::to_string(x) + ", " + std::to_string(y) + "]";
    }
};