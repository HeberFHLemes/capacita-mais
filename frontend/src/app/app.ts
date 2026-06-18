import { Component, inject, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { CarrinhoDeCompras } from './features/carrinhos/components/carrinho-de-compras/carrinho-de-compras';
import { Footer } from './shared/components/footer/footer';
import { Navbar } from './shared/components/navbar/navbar';
import { AuthService } from './features/auth/services/auth-service';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, CarrinhoDeCompras, Footer, Navbar],
  templateUrl: './app.html',
  styleUrl: './app.css'
})
export class App {
  protected readonly title = signal('capacita-mais');
  readonly authService: AuthService = inject(AuthService);
}
