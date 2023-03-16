use rapier2d::prelude::*;

mod punk;
use punk::punk_object::*;
use punk::punk_organism::*;
use punk::punk_system::*;


fn main() {
    let mut system = PunkSystem::new();
    system.organism_simulation(vector![900.0, 900.0]);
}