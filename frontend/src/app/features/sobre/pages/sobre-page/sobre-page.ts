import { Component } from '@angular/core';
import { SobreSection } from '../../components/sobre-section/sobre-section';
import { ContatoSection } from '../../components/contato-section/contato-section';

@Component({
  selector: 'app-sobre-page',
  standalone: true,
  imports: [SobreSection, ContatoSection],
  templateUrl: './sobre-page.html',
  styleUrl: './sobre-page.css',
})
export class SobrePage {

}
