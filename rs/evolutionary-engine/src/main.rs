use std::rc::Rc;
use std::cell::RefCell;

use box2d_rs::b2_body::*;
use box2d_rs::b2_fixture::*;
use box2d_rs::b2_math::*;
use box2d_rs::b2rs_common::UserDataType;
use box2d_rs::b2_world::*;
use box2d_rs::shapes::b2_polygon_shape::*;
use box2d_rs::b2_fixture::*;

#[cfg(feature="serde_support")]
use serde::{Serialize, Deserialize};

#[derive(Default, Copy, Clone, Debug, PartialEq)]
#[cfg_attr(feature = "serde_support", derive(Serialize, Deserialize))]
struct UserDataTypes;
impl UserDataType for UserDataTypes {
    type Fixture = i32;
    type Body = i32;
    type Joint = i32;
}

mod punk;
use punk::punk_object::*;

fn main() {
    println!("Hello, world!");

    

    // -- Second test
    let gravity = B2vec2::new(0.0, -10.0);

    let world = B2world::<UserDataTypes>::new(gravity);

    let mut ground_body_def = B2bodyDef::default();
    ground_body_def.position.set(0.0, -10.0);

    let ground_body = B2world::create_body(world.clone(), &ground_body_def);
    
    let mut ground_box = B2polygonShape::default();

    ground_box.set_as_box(50.0, 10.0);

    // -- First test
    let a = B2vec2::new(0.0, 0.0);
    let b = PunkObject::new(world.clone(), a, 1.0);
    // --

    B2body::create_fixture_by_shape(ground_body, Rc::new(RefCell::new(ground_box)), 0.0);

    let mut body_def = B2bodyDef::default();
    body_def.body_type = B2bodyType::B2DynamicBody;
    body_def.position.set(0.0, 4.0);
    let body = B2world::create_body(world.clone(), &body_def);

    let mut dynamic_box = B2polygonShape::default();
    dynamic_box.set_as_box(1.0, 1.0);

    let mut fixture_def = B2fixtureDef::default();
    fixture_def.shape = Some(Rc::new(RefCell::new(dynamic_box)));

    fixture_def.density = 1.0;
    fixture_def.friction = 0.3;

    B2body::create_fixture(body.clone(), &fixture_def);

    let time_step: f32 = 1.0 / 60.0;
    let velocity_iterations: i32 = 6;
    let position_iterations: i32 = 2;

    let mut position: B2vec2 = body.borrow().get_position();
    let mut angle: f32 = body.borrow().get_angle();

    for _i in 0..60 {
        world
            .borrow_mut()
            .step(time_step, velocity_iterations, position_iterations);

        position = body.borrow().get_position();
        angle = body.borrow().get_angle();

        println!("{:4.2} {:4.2} {:4.2}", position.x, position.y, angle);
    }

    println!("Finished");
}
