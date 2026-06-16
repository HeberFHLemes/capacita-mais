import { Component, inject, OnInit } from '@angular/core';
import { CarrinhoService } from '../../services/carrinho-service';
import { Carrinho } from '../../models/carrinho';
import { CarrinhoApiService } from '../../services/carrinho-api-service';
import { CurrencyPipe } from '@angular/common';

@Component({
  selector: 'app-carrinho-de-compras',
  standalone: true,
  imports: [
    CurrencyPipe
  ],
  templateUrl: './carrinho-de-compras.html',
  styleUrl: './carrinho-de-compras.css',
})
export class CarrinhoDeCompras implements OnInit {

  aberto = false;

  private readonly carrinhoService: CarrinhoService = inject(CarrinhoService);
  private readonly carrinhoApiService: CarrinhoApiService = inject(CarrinhoApiService);

  carrinho: Carrinho = { total: 0, cursos: [] };

  ngOnInit(): void {

    this.carrinhoService.aberto$.subscribe(aberto => {

      this.aberto = aberto;

      if (aberto) {
        this.carregarCarrinho();
      }

    });
  }

  private carregarCarrinho(): void {
    this.carrinhoApiService.buscarCarrinho().subscribe(
      carrinho => this.carrinho = carrinho
    );
  }

  fechar(): void {
    this.carrinhoService.fechar();
  }

  removerCurso(id: number): void {

    this.carrinhoApiService.removerItemDoCarrinho(id).subscribe(() => {
      this.carregarCarrinho();
    });

  }

  // TODO: revisar ao implementar endpoint, mas lógica a princípio será esta
  confirmarCompra(): void {
    this.carrinhoApiService.confirmarCompra(this.carrinho)
      .subscribe(() => {

        this.carrinho = {
          cursos: [],
          total: 0
        };

        this.fechar();

      });
  }
}
