import { Component, inject, Input } from '@angular/core';
import { RouterLink } from '@angular/router';
import { CarrinhoApiService } from '../../services/carrinho-api-service';
import { AuthService } from '../../../auth/services/auth-service';
import { CarrinhoService } from '../../services/carrinho-service';

@Component({
  selector: 'app-botao-adicionar-ao-carrinho',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './botao-adicionar-ao-carrinho.html',
  styleUrl: './botao-adicionar-ao-carrinho.css',
})
export class BotaoAdicionarAoCarrinho {

  isUsuarioAutenticado: boolean = inject(AuthService).isUsuarioAutenticado();

  @Input({ required: true })
  cursoId!: number;

  readonly carrinhoApiService: CarrinhoApiService = inject(CarrinhoApiService);
  readonly carrinhoService: CarrinhoService = inject(CarrinhoService);

  adicionarAoCarrinho(): void {
    this.carrinhoApiService.inserirItemNoCarrinho(this.cursoId)
      .subscribe({
        next: () => this.carrinhoService.abrir(),
        error: () => this.carrinhoService.abrir()
      }
    );
  }
}
