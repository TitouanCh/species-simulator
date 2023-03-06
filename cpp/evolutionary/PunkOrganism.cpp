#include "PunkOrganism.hpp"

PunkOrganism::PunkOrganism(PunkSystem* _p, std::vector<std::uint64_t> _dna) {
    my_system = _p;
    dna = _dna;
}

void PunkOrganism::build(float x_offset, float y_offset)
{
    int number_of_blocks = 2;
    
    for (int i = 0; i < dna.size(); i++) {
        // First 6 bytes : type
        int type = (dna[i] & 63) % number_of_blocks;

        // Regular --
        if (type == 0) {
            std::cout << "regular" << std::endl;
            std::cout << dna[i] << std::endl;
            float x = float(((dna[i] & 16320) >> 6) - 128);
            float y = float(((dna[i] & 4177920) >> 14) - 128);
            float mass = float((dna[i] & 130023424) >> 22);

            std::cout << x << " << " << y << std::endl;

            body.push_back(my_system->create_PunkObject(type, x + x_offset, y + y_offset, mass));
        }

        // Joint --
        if (type == 1) {
            std::cout << dna[i] << std::endl;
            int index1 = ((dna[i] & 16320) >> 6) % (body.size() + 1);
            int index2 = ((dna[i] & 4177920) >> 14) % (body.size() + 1);
            float distance = float((dna[i] & 130023424) >> 22);

            if (index1 < body.size() && index2 < body.size() && index1 != index2) {
                std::cout << "notcrashed1 " << index1 << " " << index2 << " " << body.size() << " " << distance << std::endl;
                std::cout << body[index1]->y << " " << body[index1]->x << " futhisshit " << body[index2]->y << " " << body[index2]->x <<  std::endl;
                joints.push_back(my_system->create_PunkJoint(type, body[index1], body[index2], distance));
                std::cout << "notcrashed2" << std::endl;
            }
        }
    }
}