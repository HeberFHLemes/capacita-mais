import { Component, inject, OnInit, ViewChild } from '@angular/core';
import { CursosApiService } from '../../services/cursos-api-service';
import { Curso } from '../../models/curso';
import { CursoCard } from '../../components/curso-card/curso-card';
import { CursoSearchBar } from '../../components/curso-search-bar/curso-search-bar';
import { CategoriaFilter } from '../../components/categoria-filter/categoria-filter';
import { CustoFilter } from '../../components/custo-filter/custo-filter';
import { normalizarString } from '../../../../shared/utils/string-utils';
import { CategoriaFiltro } from '../../../categorias/models/categoria-filtro';
import { CategoriaApiService } from '../../../categorias/services/categoria-api-service';

@Component({
  selector: 'app-cursos-page',
  standalone: true,
  imports: [CursoCard, CursoSearchBar, CategoriaFilter, CustoFilter],
  templateUrl: './cursos-page.html',
  styleUrl: './cursos-page.css',
})
export class CursosPage implements OnInit {

  cursos: Curso[] = [];

  cursosExibidos: Curso[] = [];

  categorias: CategoriaFiltro[] = [];

  termoBusca = '';

  filtroCusto = 'todos';

  @ViewChild(CursoSearchBar) searchBar!: CursoSearchBar;

  @ViewChild(CustoFilter) custoFilter!: CustoFilter;

  private readonly cursosApiService: CursosApiService = inject(CursosApiService);

  private readonly categoriasApiService: CategoriaApiService = inject(CategoriaApiService);

  ngOnInit(): void {
    this.montarCatalogo();
  }

  montarCatalogo() {
    this.cursosApiService.buscarCursos().subscribe((cursos) => {
      this.cursos = cursos;
      this.cursosExibidos = cursos;
    });

    this.categoriasApiService.buscarCategorias().subscribe((categorias) => {
      categorias.forEach((categoria) => {
        this.categorias.push({
          id: categoria.id,
          nome: categoria.nome,
          selecionada: false
        })
      });
    });
  }

  onBuscaChange(termo: string): void {
    this.termoBusca = termo;
    this.aplicarFiltros();
  }

  onCustoChange(custo: string): void {
    this.filtroCusto = custo;
    this.aplicarFiltros();
  }

  onCategoriaChange(): void {
    this.aplicarFiltros();
  }

  aplicarFiltros(): void {
    this.cursosExibidos = this.cursos.filter(curso => {
      const busca = !this.termoBusca
        || normalizarString(curso.nome).includes(normalizarString(this.termoBusca));

      const custo =
        this.filtroCusto === 'todos'    ? true :
        this.filtroCusto === 'gratuito' ? curso.preco === 0 :
        this.filtroCusto === 'pago'     ? curso.preco > 0 : true;

      const categoriasSelecionadas = this.categorias
        .filter(c => c.selecionada)
        .map(c => c.id);

      const categoria = categoriasSelecionadas.length === 0
        || categoriasSelecionadas.includes(curso.categoria.id);

      return busca && custo && categoria;
    });
  }

  limparFiltros(): void {
    this.termoBusca = '';
    this.filtroCusto = 'todos';
    this.categorias.forEach(categoria => {
      categoria.selecionada = false;
    });
    this.searchBar.limpar();
    this.custoFilter.limpar();
    this.cursosExibidos = [...this.cursos];
  }
}
