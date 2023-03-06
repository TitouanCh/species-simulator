use rapier2d::prelude::*;

mod punk;
use punk::punk_object::*;
use punk::punk_system::*;

fn main() {
    let mut system = PunkSystem::new();
    system.add_punk_object(vector![0.0, 10.0], 5.0);
    system.add_punk_object(vector![20.0, 10.0], 5.0);
    system.add_punk_object(vector![40.0, 10.0], 5.0);

    system.step(0.5);

    system.print3();
}