use std::vec::Vec;

use rapier2d::dynamics::{
    CCDSolver, ImpulseJointSet, IntegrationParameters, IslandManager, MultibodyJointSet,
    RigidBodySet,
};
use rapier2d::geometry::{BroadPhase, ColliderSet, CollisionEvent, ContactForceEvent, NarrowPhase};
use rapier2d::math::{Real, Vector};
use rapier2d::pipeline::{PhysicsHooks, PhysicsPipeline, QueryPipeline};

use rapier2d::prelude::*;

use crate::PunkObject;

pub struct PunkSystem {
    pub islands: IslandManager,
    pub broad_phase: BroadPhase,
    pub narrow_phase: NarrowPhase,
    pub bodies: RigidBodySet,
    pub colliders: ColliderSet,
    pub impulse_joints: ImpulseJointSet,
    pub multibody_joints: MultibodyJointSet,
    pub ccd_solver: CCDSolver,
    pub pipeline: PhysicsPipeline,
    pub query_pipeline: QueryPipeline,
    pub integration_parameters: IntegrationParameters,
    pub gravity: Vector<Real>,
    pub hooks: Box<dyn PhysicsHooks>,

    pub punk_objects: Vec<PunkObject>,

    pub record: Vec<Vec<Vec<Vec<f32>>>>
    
}

impl PunkSystem {
    pub fn new() -> Self {
        Self {
            islands: IslandManager::new(),
            broad_phase: BroadPhase::new(),
            narrow_phase: NarrowPhase::new(),
            bodies: RigidBodySet::new(),
            colliders: ColliderSet::new(),
            impulse_joints: ImpulseJointSet::new(),
            multibody_joints: MultibodyJointSet::new(),
            ccd_solver: CCDSolver::new(),
            pipeline: PhysicsPipeline::new(),
            query_pipeline: QueryPipeline::new(),
            integration_parameters: IntegrationParameters::default(),
            gravity: Vector::y() * -9.81,
            hooks: Box::new(()),

            //event_handler: eve,

            punk_objects: Vec::new(),

            record: Vec::new()
        }
    }

    pub fn add_punk_object(&mut self, position : Vector<Real>, mass : f32) {
        let collider = ColliderBuilder::ball(mass)
            .mass(mass)
            .restitution(0.5)
            .build();
        
        let rigid_body = RigidBodyBuilder::dynamic()
            .translation(position)
            .build();
        
        let body_handle = self.bodies.insert(rigid_body);
        self.colliders.insert_with_parent(collider, body_handle, &mut self.bodies);

        let object = PunkObject::new(position, mass, body_handle);

        self.punk_objects.push(object);
    }

    pub fn step(&mut self, delta : f32) {
        // Record ---
        let mut frame = Vec::new();

        let mut punk_objects_data = Vec::new();

        for punk_object in &self.punk_objects {
            punk_objects_data.push(punk_object.record(&self.bodies));
        }

        frame.push(punk_objects_data);

        self.record.push(frame);

        // Physics ---
        self.pipeline.step(
            &self.gravity,
            &self.integration_parameters,
            &mut self.islands,
            &mut self.broad_phase,
            &mut self.narrow_phase,
            &mut self.bodies,
            &mut self.colliders,
            &mut self.impulse_joints,
            &mut self.multibody_joints,
            &mut self.ccd_solver,
            Some(&mut self.query_pipeline),
            &(),
            &()
        );
    }

    pub fn process(&mut self, delta: f32, epsilon: f32) {
        let mut i = 0.0;
        while i < delta {
            self.step(epsilon);
            i += epsilon;
        }
    }

    pub fn get_frame(&self, frame : usize) -> Vec<Vec<Vec<f32>>> {
        if frame < self.record.len() {
            return self.record[frame].clone();
        }
        return Vec::new();
    }

    pub fn print3(&self) -> String {
        let mut result = String::new();
        for i in 0..3 {
            let body = &self.bodies[self.punk_objects[i].handle];
            result += &format!("{}: [{}, {}] ,", i, body.translation().x, body.translation().y);
        }

        result
    }
}