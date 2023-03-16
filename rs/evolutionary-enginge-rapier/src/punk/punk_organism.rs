use std::vec::Vec;
use rapier2d::math::{Real, Vector};

use rapier2d::prelude::*;

use rapier2d::dynamics::{
    RigidBodyHandle, RigidBodySet
};

use crate::PunkSystem;

//#[derive(Copy, Clone)]
pub struct PunkOrganism {
    pub dna : Vec<i16>,
    pub objectIdx : Vec<usize>
}

impl PunkOrganism {
    pub fn new(dna: Vec<i16>) -> Self {
        Self {
            dna,
            objectIdx : Vec::new()
        }
    }

    fn read(&mut self) -> PunkEmbryo {
        let MAX_SIZE = 32;
        let MAX_MASS = 16; 

        let mut dnaMol = Vec::new(); 

        let mut i = 0;
        
        // Molecule
        while i < self.dna.len() {
            // Symetries
            let mut symetries = Vec::new();
            let mut j = i;
            while j < self.dna.len() {
                if self.dna[j] % 2 == 1 {
                    symetries.push(self.dna[i + j + 1] as f32);
                    j += 2;
                } else {
                    break;
                }
            }

            // Insert Molecule
            let x : f32 = (self.dna[i + j + 1] % MAX_SIZE * 10) as f32 / 10.0;
            let y : f32 = (self.dna[i + j + 2] % MAX_SIZE * 10) as f32 / 10.0;

            let mass : f32 = (self.dna[i + j + 3] % (MAX_MASS * 10)) as f32 / 10.0;

            dnaMol.push(PunkMol {position : vector![x, y], mass : mass, symetries : symetries});
            //println!("dna mol : {:?}", dnaMol);

            i += 3 + j;
        }

        // Embryo
        let mut embryos : Vec<PunkEmbryo> = Vec::new();
        let mut embryo = PunkEmbryo { position : vector![0.0, 0.0], children : Vec::new(), mass : 10.0 };

        for mol in dnaMol.iter().rev() {
            let mut children : Vec<PunkEmbryo> = Vec::new();
            children.push(embryos[embryos.len() - 1].clone());

            for sym in mol.symetries.iter() {
                let mut tilted = embryos[embryos.len() - 1].clone();
                let angle = *sym;
                tilted.position = vector![mol.position.x * angle.cos() - mol.position.y * angle.sin(), mol.position.x * angle.sin() + mol.position.y * angle.cos()];
                children.push(tilted);
            }

            embryo = PunkEmbryo { position : mol.position, mass : mol.mass as f32, children : children };
            //println!("dna mol : {:?}", embryo);
            embryos.push(embryo);
        }

        embryos[embryos.len() - 1].clone()
    }

    fn make(&mut self, system : &mut PunkSystem, position : Vector<Real>, embryo : PunkEmbryo) {

        // Create all children
        let mut childrenIdx = Vec::new();

        for child in embryo.children.iter() {
            self.make(system, position + embryo.position, child.clone());
            childrenIdx.push(system.punk_objects.len() - 1);
        }

        // Add itself
        system.add_punk_object(embryo.position + position, embryo.mass);
        let selfIdx = system.punk_objects.len() - 1;

        self.objectIdx.push(selfIdx);

        // Connect to all children
        for (i, child) in embryo.children.iter().enumerate() {
            system.add_joint(selfIdx, childrenIdx[i], child.position.into());
        }
    }

    pub fn setup(&mut self, system : &mut PunkSystem, position : Vector<Real>) {
        let embryo = self.read();
        self.make(system, position, embryo);
    }

}

//#[derive(Debug)]
pub struct PunkMol {
    pub position : Vector<Real>,
    pub mass : f32,
    pub symetries : Vec<f32>
}

#[derive(Clone)]
pub struct PunkEmbryo {
    pub position : Vector<Real>,
    pub mass : f32,
    pub children : Vec<PunkEmbryo> 
}