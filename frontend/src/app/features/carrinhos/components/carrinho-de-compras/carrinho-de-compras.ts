import { Component, inject, OnInit } from '@angular/core';
import { CarrinhoService } from '../../services/carrinho-service';
import { Carrinho } from '../../models/carrinho';
import { CarrinhoApiService } from '../../services/carrinho-api-service';
import { CurrencyPipe } from '@angular/common';
import { Alerta } from '../../../../shared/components/alerta/alerta';
import { HttpErrorResponse } from '@angular/common/http';

@Component({
  selector: 'app-carrinho-de-compras',
  standalone: true,
  imports: [CurrencyPipe, Alerta],
  templateUrl: './carrinho-de-compras.html',
  styleUrl: './carrinho-de-compras.css',
})
export class CarrinhoDeCompras implements OnInit {

  aberto = false;
  carrinho: Carrinho = { total: 0, cursos: [] };

  // feedback
  mensagem: string|null = null;
  tipoMensagem: 'success' | 'danger' | null = null;

  private readonly carrinhoService: CarrinhoService = inject(CarrinhoService);
  private readonly carrinhoApiService: CarrinhoApiService = inject(CarrinhoApiService);

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

    this.limparMensagem();
  }

  removerCurso(id: number): void {

    this.carrinhoApiService.removerItemDoCarrinho(id).subscribe(() => {
      this.carregarCarrinho();
    });

  }

  limparMensagem(): void {
    this.mensagem = null;
    this.tipoMensagem = null;
  }

  confirmarCompra(): void {
    this.limparMensagem();

    this.carrinhoApiService.confirmarCompra(this.carrinho.total)
      .subscribe({
        next: () => {
          this.carrinho = { // limpa o carrinho
            cursos: [],
            total: 0
          };

          this.tipoMensagem = 'success';
          this.mensagem = 'Compra realizada com sucesso!';
        },
        error: (erro: HttpErrorResponse) => {

          switch (erro.status) {
            case 409:
              this.mensagem = 'Alguns cursos já foram adquiridos.';
              break;

            case 422:
              this.mensagem = 'Dados inválidos';
              break;

            default:
              this.mensagem = 'Não foi possível concluir a compra.';
          }
          this.tipoMensagem = 'danger';
        }
      });
  }
}
