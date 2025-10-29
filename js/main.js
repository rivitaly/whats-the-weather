//Required for Rendering
import * as THREE from 'three';
//Required for loading objects
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

//Variables
const fov = 90;
const scale = 0.1;
const lightColor = 0xffffff;
const rotSpeedY = 0.001;
const distance = 100;

//Scene Setup
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(fov, window.innerWidth / window.innerHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer({alpha: true});    //Parameter allows alpha
renderer.setSize(window.innerWidth, window.innerHeight);
//Where you want the render to be placed
var container = document.getElementById("planet")
container.appendChild(renderer.domElement);

//To load 3D objects with type *.gltf
const loader = new GLTFLoader();
const path = 'assets/'
const file = 'earth-glTF'   //This work is based on "Планета Земля. Planeet Aarde. 行星地球." (https://sketchfab.com/3d-models/planeet-aarde-1dbdb56dd730412cb7e23f772b3794e5) by dima051983 (https://sketchfab.com/dima051983) licensed under CC-BY-4.0 (http://creativecommons.org/licenses/by/4.0/)
let object;

//Load object and its properties
loader.load(`${path}${file}/scene.gltf`,
    function(gltf){
        //Grab the object
        object = gltf.scene;

        //Set object properties
        object.scale.set(scale, scale, scale);

        //Add to scene
        scene.add(object);
    }
, undefined, function(error) {

    console.error(error);

});

camera.position.z = distance;

//Adds a directionalLight
const topLight = new THREE.DirectionalLight(lightColor, 1);
topLight.position.set(500, 500, 500);
topLight.castShadow = true;
scene.add(topLight);

//Need to learn how to setup spotLight

//Adds an ambientLight
const ambientLight = new THREE.AmbientLight(lightColor, 1);
scene.add(ambientLight);

//Render
function animate() {
    //Only perform operations when object is loaded
    if(object){
        object.rotation.y += rotSpeedY;
        /*
            Instead of rotating like this, I think it'd be good to connect whatever Weather API we use
            to calculate longitude and latitude and make use of a function call to rotate the earth to
            face towards the user at the correct location to be used.  Think it'd be worth looking into
            figuring out different easing styles rather than linear interpolation? (Ease Out - Quint?)
         */
    }

    renderer.render(scene, camera);
}
renderer.setAnimationLoop(animate);