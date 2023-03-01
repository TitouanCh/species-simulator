#include <iostream>
#include "system.hpp"

using namespace std;

int main() {
  cout << "Starting" << endl;

  PunkSystem a;
  a.add_PunkObject(10, 10, 5);
  a.add_PunkObject(11, 12, 5);
  a.add_PunkObject(30, 20, 5);
  
  for (int i = 0; i < 50; i++) {
    a.step(0.1);
    cout << i << " : " << a.print3() << endl;
  }

  cout << "Finished" << a.record.size() << endl;

  return 0;
}