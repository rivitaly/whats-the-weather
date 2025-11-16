//Required for Rendering
import * as THREE from 'three';
//Required for loading objects
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

//Variables
const fov = 90;
const scale = 0.1;
const lightColor = 0xffffff;
const rotSpeedY = 0.001;
const distance = 60;
let isPlaying = false;
let currRot = new THREE.Vector2(0,0);
let targetRot = new THREE.Vector2(0,0);
let rotTime = 1000; //in ms
let rotStart = 0;
let isRotating =  false;

//Where you want the render to be placed
var container = document.getElementById("planet")

//Scene Setup
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(fov, container.clientWidth / container.clientHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer({alpha: true});    //Parameter allows alpha
renderer.setSize(container.clientWidth, container.clientHeight);
container.appendChild(renderer.domElement);

window.addEventListener('resize', () => {
  camera.aspect = container.clientWidth / container.clientHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(container.clientWidth, container.clientHeight);
});

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

export function rotatePlanet(long, lat){
    if(!isPlaying) { isPlaying = true; }

    //Get current rotation
    currRot.x = object.rotation.x;
    currRot.y = object.rotation.y;

    //Get target rotation
    targetRot.x = THREE.MathUtils.degToRad(-long);
    targetRot.y = 1 + THREE.MathUtils.degToRad(lat);

    rotStart = performance.now();
    isRotating = true;
}

function cubicEaseOut(t) { return 1 - Math.pow(1 - t, 3); }

function animateRotation(){
    if(!isRotating) { return; }

    const now = performance.now();
    const diff = now - rotStart;
    const currTime = Math.min(diff / rotTime, 1);
    const ease = cubicEaseOut(currTime);

    object.rotation.x = THREE.MathUtils.lerp(currRot.x, targetRot.x, ease);
    object.rotation.y = THREE.MathUtils.lerp(currRot.y, targetRot.y, ease);

    //Only rotate for the duration needed
    if(currTime >= 1) { isRotating = false; }
}

//Render
function animate() {

    //Only perform operations when object is loaded
    if(!isPlaying){
        if(object)
            object.rotation.y += rotSpeedY;
    }
    else {
        if(isRotating)
            animateRotation();
    }

    renderer.render(scene, camera);
}
renderer.setAnimationLoop(animate);