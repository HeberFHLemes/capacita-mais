import { Component } from '@angular/core';
import { HeroSection } from '../../components/hero-section/hero-section';
import { MissaoSection } from '../../components/missao-section/missao-section';

@Component({
  selector: 'app-home-page',
  standalone: true,
  imports: [HeroSection, MissaoSection],
  templateUrl: './home-page.html',
  styleUrl: './home-page.css',
})
export class HomePage {

}
