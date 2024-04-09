import { Component } from '@angular/core';
import { DOCUMENT } from '@angular/common';
import { Inject } from '@angular/core';

@Component({
  selector: 'app-how-to',
  templateUrl: './how-to.component.html',
  styleUrls: ['./how-to.component.css']
  
})
export class HowToComponent {
  link = "./assets/how-to-build-pc-rig.jpg"
  link2 = "./assets/tools.jpg"
  link3 = "./assets/the-cpu.jpg"
  link4 = "./assets/cpu-install.jpg"
  link5 = "./assets/cpu-cooler-install.jpg"
  link6 = "./assets/aio.jpg"
  link7 = "./assets/thermal-paste.jpg"
  link8 = "./assets/cooler-side.jpg"
  link9 = "./assets/bracket-install.jpg"
  link10 = "./assets/bracket-parts.jpg"
  link11 = "./assets/thermal-paste2.jpg"
  link12 = "./assets/cpu-fan-pin.jpg"
  link13 = "./assets/cpu-fan-pin2.jpg"
  link14 = "./assets/ram-install.jpg"
  link15 = "./assets/ram-install2.jpg"
  link16 = "./assets/m2-install.jpg"
  link17 = "./assets/mbo-pic.jpg"
  link18 = "./assets/m2-install2.jpg"
  link19 = "./assets/m2-install3.jpg"
  link20 = "./assets/m2-screw.jpg"
  link21 = "./assets/mbo-build2.jpg"
  link22 = "./assets/standoffs.jpg"
  link23 = "./assets/io-shield.jpg"
  link24 = "./assets/io-shield2.jpg"
  link25 = "./assets/install-into-case.jpg"
  link26 = "./assets/standoff-screwing-in.jpg"
  link27 = "./assets/cable-management.jpg"
  link28 = "./assets/psu.jpg"
  link29 = "./assets/storage.jpg"
  link30 = "./assets/gpu-install.jpg"
  link31 = "./assets/gpu-bracket.jpg"
  link32 = "./assets/gpu-cable.jpg"
  link33 = "./assets/gpu-cable-plug.jpg"
  link34 = "./assets/gpu-cable2.jpg"
  link35 = "./assets/case-conns.jpg"
  link36 = "./assets/case-conns2.jpg"
  link37 = "./assets/power-sw.jpg"
  link38 = "./assets/gpu-install2.jpg"
  link39 = "./assets/pc-turn-on.jpg"
  link40 = "./assets/cable-managament.jpg"
  link41 = "./assets/cable-management2.jpg"
  link42 = "./assets/os-install.jpg"
  link43 = "./assets/bios.jpg"
  link44 = "./assets/back-to-top.png"
  constructor(@Inject(DOCUMENT) private document: Document) {}
  
  scrollToTop(): void {
    return this.document.body.scrollIntoView({
      behavior: 'smooth',
      block: 'start',
      inline: 'start'
    });
  }  
}
