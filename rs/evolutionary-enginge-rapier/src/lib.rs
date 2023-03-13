use std::vec::Vec;

use rapier2d::prelude::*;

mod punk;
use punk::punk_object::*;
use punk::punk_system::*;

use wasm_bindgen::prelude::*;

use serde_json::{Result, Value};

/*
fn main() {
    let mut system = PunkSystem::new();
    system.add_punk_object(vector![0.0, 10.0], 5.0);
    system.add_punk_object(vector![20.0, 10.0], 5.0);
    system.add_punk_object(vector![40.0, 10.0], 5.0);

    system.step(0.5);

    system.print3();
}
*/

#[wasm_bindgen]
pub struct PunkContext {
    // Public --

    // Private -- don't need to be serialized
    systems : Vec<PunkSystem>,
} 

#[wasm_bindgen]
impl PunkContext {
    pub fn new() -> Self {
        Self {
            systems: Vec::new()
        }
    }

    pub fn create_punk_system(&mut self) -> usize {
        let system = PunkSystem::new();
        self.systems.push(system);

        self.systems.len() - 1
    }

    pub fn base_simulation(&mut self, system_index : usize, simulation_width : f32, simulation_height : f32) {
        self.systems[system_index].base_simulation(vector![simulation_width, simulation_height]);
    }

    pub fn process_system(&mut self, system_index : usize, delta : f32, epsilon : i32) {
        self.systems[system_index].process(delta, epsilon);
    }

    pub fn get_system_frame(&self, system_index : usize, frame : usize) -> String {
        match serde_json::to_string(&self.systems[system_index].get_frame(frame)) {
            Ok(j) => return j,
            Err(_e) => return String::new()
        }
    }

    pub fn test_system(&mut self, system_index : usize) -> String {
        self.systems[system_index].add_punk_object(vector![0.0, 10.0], 5.0);
        self.systems[system_index].add_punk_object(vector![20.0, 10.0], 5.0);
        self.systems[system_index].add_punk_object(vector![40.0, 10.0], 5.0);

        self.systems[system_index].step(4);
        self.systems[system_index].step(4);
        self.systems[system_index].step(4);

        self.systems[system_index].print3()
    }
}