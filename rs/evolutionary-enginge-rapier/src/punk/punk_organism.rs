use std::vec::Vec;
use rapier2d::math::{Real, Vector};

use rapier2d::prelude::*;

use rapier2d::dynamics::{
    RigidBodyHandle, RigidBodySet
};

use crate::PunkSystem;

//#[derive(Copy, Clone)]
pub struct PunkOrganism {
    pub dna : Vec<i16>
}

impl PunkOrganism {
    pub fn new(dna: Vec<i16>) -> Self {
        Self {
            dna
        }
    }

    pub fn make(self, system : &mut PunkSystem) {
        let mut i = 0;
        let dna_size : i16 = self.dna.len().try_into().unwrap();
        
        while i < self.dna.len() {
            let i_16 : i16 = i.try_into().unwrap();
            let u_dna : usize = usize::from(i);

            // Static - 1: position_x, 2: position_y 3: mass
            if self.dna[i] == 0 && i + 2 < self.dna.len() {
                system.add_punk_object(
                    vector![self.dna[i + 1].into(), self.dna[i + 2].into()],
                    self.dna[i + 3].into()
                );
                i += 3;
            
            // Joint - 1: 13: length_x, 4: length_y
            } else if self.dna[i] == 1 && i > 3 && i + 3 < self.dna.len() {
                if self.dna[i + 1] < i_16 && self.dna[i + 2] < i_16 {
                    system.add_joint(
                        self.dna[i + 1] as usize,
                        self.dna[i + 2] as usize,
                        point![self.dna[i + 3].into(), self.dna[i + 4].into()]
                    );
                }
                i += 4;
            } else {
                i += 1;
            }
        }
    }
}