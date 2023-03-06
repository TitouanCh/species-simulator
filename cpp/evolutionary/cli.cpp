#include <iostream>
#include "PunkSystem.hpp"

using namespace std;

int main() {
  cout << "Starting" << endl;
  
  PunkSystem a;
  //a.add_PunkObject(10, 10, 5);
  //a.add_PunkObject(10, 12, 5);
  //a.add_PunkObject(30, 20, 5);

  //a.add_Organism({21849841421, 2409821409128, 124908120498124, 2409274891374, 1294210492412}, 50, 50);
  a.add_random_Organism(20, 20);
  cout << "orga1" << endl;
  a.add_random_Organism(50, 550);
  cout << "orga2" << endl;
  a.add_random_Organism(70, 60);
  cout << "orga3" << endl;
  a.add_random_Organism(30, 40);
  cout << "orga4" << endl;

  for (int i = 0; i < 50; i++) {
    cout << i << " : " << a.print3() << endl;
    a.step(0.1);
  }

  cout << "Finished" << a.record.size() << endl;
  


  //std::uint64_t a = 14199112138023549963;
  //int b = 4177920;

  //std::cout << float(((a & 4177920) >> 14)) << endl;
 

  return 0;
}