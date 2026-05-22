import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { AdminNav } from '../../components/admin-nav/admin-nav';

@Component({
  selector: 'app-cadastro-curso-page',
  standalone: true,
  imports: [RouterLink, AdminNav],
  templateUrl: './cadastro-curso-page.html',
  styleUrl: './cadastro-curso-page.css',
})
export class CadastroCursoPage {

}
