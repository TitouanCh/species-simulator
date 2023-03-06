use rapier2d::math::{Real, Vector};

use rapier2d::dynamics::{
    RigidBodyHandle
};

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
}
