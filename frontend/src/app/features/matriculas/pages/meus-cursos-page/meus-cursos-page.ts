import { Component, inject, OnInit } from '@angular/core';
import { AuthService } from '../../../auth/services/auth-service';
import { MeusCursosApiService } from '../../services/meus-cursos-api-service';
import { CursoMatriculado } from '../../models/curso-matriculado';
import { CursoMatriculadoCard } from '../../components/curso-matriculado-card/curso-matriculado-card';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-meus-cursos-page',
  standalone: true,
  imports: [CursoMatriculadoCard, RouterLink],
  templateUrl: './meus-cursos-page.html',
  styleUrl: './meus-cursos-page.css',
})
export class MeusCursosPage implements OnInit {

  readonly authService: AuthService = inject(AuthService);
  readonly meusCursosApiService: MeusCursosApiService = inject(MeusCursosApiService);

  nomeUsuario: string|null = null;
  meusCursos: CursoMatriculado[] = [];

  ngOnInit() {
    this.carregarNomeUsuario();
    this.carregarMeusCursos();
  }

  carregarNomeUsuario() {
    this.nomeUsuario = this.authService.usuario()?.nome ?? null;
  }

  carregarMeusCursos(): void {
    this.meusCursosApiService.buscarMeusCursos()
      .subscribe((resposta) => {
        this.meusCursos = resposta;
      })
  }
}
