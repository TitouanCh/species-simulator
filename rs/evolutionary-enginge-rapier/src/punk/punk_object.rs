use rapier2d::math::{Real, Vector};

use rapier2d::dynamics::{
    RigidBodyHandle, RigidBodySet
};

#[derive(Copy, Clone)]
pub struct PunkObject {
    pub position: Vector<Real>,
    pub mass: f32,
    pub handle: RigidBodyHandle
}

impl PunkObject {
    pub fn new(position: Vector<Real>, mass: f32, handle: RigidBodyHandle) -> Self {
        Self {
            position,
            mass,
            handle
        }
    }

    pub fn record(self, bodies : &RigidBodySet) -> Vec<f32> {
        let mut data = Vec::new();
        data.push(bodies[self.handle].translation().x);
        data.push(bodies[self.handle].translation().y);
        data.push(self.mass);

        data
    }
}
