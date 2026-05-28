import { Component } from '@angular/core';
import { HeroSection } from '../../components/hero-section/hero-section';
import { CursosPage } from '../../../cursos/pages/cursos-page/cursos-page';
import { Destaques } from '../../../cursos/components/destaques/destaques';

@Component({
  selector: 'app-home-page',
  standalone: true,
  imports: [HeroSection, CursosPage, Destaques],
  templateUrl: './home-page.html',
  styleUrl: './home-page.css',
})
export class HomePage {

}
