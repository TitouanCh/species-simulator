#pragma once
#include <vector>
#include <string>
#include <functional>
#include <cmath>

#include <iostream>

float norme2(float x1, float y1, float x2, float y2);

uint64_t random64();

int random(int max, int buffer);

struct PunkJoint
{
    PunkObject* object1;
    PunkObject* object2;
    float distance;

    PunkJoint(PunkObject* _object1, PunkObject* _object2, float _distance);

    void process();

    std::vector<float> record();
};