use std::rc::Rc;
use std::cell::RefCell;

use box2d_rs::b2_body::*;
use box2d_rs::b2_fixture::*;
use box2d_rs::b2_math::*;
use box2d_rs::b2rs_common::UserDataType;
use box2d_rs::b2_world::*;
use box2d_rs::shapes::b2_polygon_shape::*;
use box2d_rs::b2_fixture::*;



pub struct PunkObject {
    position : B2vec2,
    mass : f32,

    body_def : B2bodyDef<UserDataType>,
    //body : f32,
    //shape : f32,
}

impl PunkObject {
    pub fn new(world : B2worldPtr<UserDataType>, position : B2vec2, mass : f32) -> Self {
        //Self.body_def = B2bodyDef::default();
        //Self.body_def.position.set(0.0, -10.0);

        //Self.body = B2world::create_body(world.clone(), &self.body_def);
        //Self.shape = B2circleShape::default();

        Self {
            position : position,
            mass : mass,
            body_def : B2bodyDef::default()

        }
    }
}