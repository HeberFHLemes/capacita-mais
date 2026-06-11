import { Component } from '@angular/core';
import {RouterLink} from "@angular/router";

@Component({
  selector: 'app-cadastro-page',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './cadastro-page.html',
  styleUrl: './cadastro-page.css',
})
export class CadastroPage {
  realizarCadastro() {
    // TODO
  }
}
