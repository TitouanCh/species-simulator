use std::vec::Vec;
use rapier2d::math::{Real, Vector};
use nalgebra::distance;

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
        let MAX_SIZE = 16;
        let MAX_MASS = 6; 
        let MAX_ANGLE = 6.2831;

        let mut dnaMol = Vec::new(); 

        let mut i = 0;
        
        // Molecule
        while i < self.dna.len() {
            // Symetries
            let mut symetries = Vec::new();

            while i < self.dna.len() {
                if self.dna[i] % 2 == 1 {
                    symetries.push((self.dna[i + 1] as f32 % MAX_ANGLE).abs());
                    i += 2;
                } else {
                    break;
                }
            }

            // Insert Molecule
            if i < self.dna.len() - 3 {
                let x : f32 = (self.dna[i + 1] % (MAX_SIZE * 10)) as f32 / 10.0;
                let y : f32 = (self.dna[i + 2] % (MAX_SIZE * 10)) as f32 / 10.0;

                let mass : f32 = (self.dna[i + 3] % (MAX_MASS * 10)) as f32 / 10.0;
                let mass = mass.abs();

                let mol = PunkMol {position : vector![x, y], mass : mass, symetries : symetries};
                println!("dna mol -> | position ({} {}), mass ({}), symetries ({:?})", mol.position.x, mol.position.y, mol.mass, mol.symetries);
                
                dnaMol.push(mol);
            }

            i += 3;
        }

        println!("dna len : {:?}", dnaMol.len());

        // Embryo
        let mut embryos : Vec<PunkEmbryo> = Vec::new();
        let mut embryo = PunkEmbryo { position : vector![0.0, 0.0], children : Vec::new(), mass : 10.0 };

        for mol in dnaMol.iter().rev() {
            let mut children : Vec<PunkEmbryo> = Vec::new();
            if embryos.len() > 0 {
                children.push(embryos[embryos.len() - 1].clone());

                for sym in mol.symetries.iter() {
                    let mut tilted = embryos[embryos.len() - 1].clone();
                    let angle = *sym;
                    tilted.position = vector![mol.position.x * angle.cos() - mol.position.y * angle.sin(), mol.position.x * angle.sin() + mol.position.y * angle.cos()];
                    children.push(tilted);
                }
            }

            embryo = PunkEmbryo { position : mol.position, mass : mol.mass as f32, children : children };
            println!("embryo : {:?}, nchildren : {}", embryo.position, embryo.children.len());
            embryos.push(embryo);
        }

        println!("--- Embryo Structure DONE!");

        embryos[embryos.len() - 1].clone()
    }

    fn make(&mut self, system : &mut PunkSystem, position : Vector<Real>, embryo : &PunkEmbryo, validated_mol_list : &Vec<PunkMol>) -> bool {

        // Check if valid
        let mut valid = false;
        for mol in validated_mol_list {
            if mol.mass == embryo.mass && mol.position == embryo.position {
                valid = true;
            }
        }
        if !valid { return false; }

        println!("-o- Making Embryo - info / {:?}, nchildren : {} ;", embryo.position, embryo.children.len());

        // Create all children
        let mut childrenIdx = Vec::new();
        let mut real_childrenIdx = Vec::new();

        for (i, child) in embryo.children.iter().enumerate() {
            if self.make(system, position + embryo.position, &child, validated_mol_list) {
                childrenIdx.push(system.punk_objects.len() - 1);
                real_childrenIdx.push(i);
            }
        }

        // Add itself
        system.add_punk_object(embryo.position + position, embryo.mass);
        let selfIdx = system.punk_objects.len() - 1;

        self.objectIdx.push(selfIdx);

        // Connect to all children
        for (i, j) in real_childrenIdx.iter().enumerate() {
            //system.add_joint(selfIdx, childrenIdx[i], embryo.children[*j].position.into());
        }

        true
    }

    pub fn setup(&mut self, system : &mut PunkSystem, position : Vector<Real>) {
        let embryo = self.read();
        let validated_mol_list = self.validate(&embryo, Vec::new());
        self.make(system, position, &embryo, &validated_mol_list);
    }

    fn validate(&mut self, embryo : &PunkEmbryo, mut validated_mol_list : Vec<PunkMol>) -> Vec<PunkMol> {
        
        println!("-v- Validating Embryo - info / {:?}, nchildren : {} ;", embryo.position, embryo.children.len());

        let mut is_colliding = false;

        // Check if embryo part collides with anything
        for mol in &validated_mol_list {
            let point1 : Point<Real> = mol.position.into();
            let point2 : Point<Real> = embryo.position.into();

            // -> if it does, do not validate
            if distance(&point2, &point1) < mol.mass + embryo.mass {
                is_colliding = true;
                break;
            }
        }

        // -> if it doesn't validate it and check children
        if !is_colliding {
            let validated_mol = PunkMol { position : embryo.position, mass : embryo.mass, symetries : Vec::new()};
            validated_mol_list.push(validated_mol);

            for child in embryo.children.iter() {
                validated_mol_list = self.validate(&child, validated_mol_list);
            }
        }

        validated_mol_list
    }

}

#[derive(Clone)]
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