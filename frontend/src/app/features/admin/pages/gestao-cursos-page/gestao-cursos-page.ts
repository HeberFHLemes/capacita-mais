import { Component } from '@angular/core';
import {RouterLink} from '@angular/router';
import {CursoSearchBar} from '../../../cursos/components/curso-search-bar/curso-search-bar';

@Component({
  selector: 'app-gestao-cursos-page',
  imports: [
    RouterLink,
    CursoSearchBar
  ],
  templateUrl: './gestao-cursos-page.html',
  styleUrl: './gestao-cursos-page.css',
})
export class GestaoCursosPage {

}
