import { Directive, ElementRef, OnDestroy, OnInit } from '@angular/core';
import { Tooltip } from 'bootstrap';

@Directive({
  selector: '[appTooltip]',
  standalone: true
})
export class TooltipDirective implements OnInit, OnDestroy {

  // Habilita as tooltips do Bootstrap (vêm desativas por padrão)
  // https://getbootstrap.com/docs/5.0/components/tooltips/

  private tooltip!: Tooltip;

  constructor(private el: ElementRef) {
    this.el.nativeElement.setAttribute('data-bs-toggle', 'tooltip');
  }

  ngOnInit() {
    this.tooltip = new Tooltip(this.el.nativeElement);
  }

  ngOnDestroy() {
    this.tooltip?.dispose();
  }
}
