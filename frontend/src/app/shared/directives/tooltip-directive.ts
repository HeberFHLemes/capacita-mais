import { Directive, ElementRef, OnDestroy, OnInit } from '@angular/core';
import type { Tooltip } from 'bootstrap';

// import normal do Tooltip chamava o script global do Boostrap uma segunda vez,
// então import type com abstração do new.
declare const bootstrap: {
  Tooltip: new (element: Element, options?: Partial<Tooltip.Options>) => Tooltip;
};

@Directive({
  selector: '[appTooltip]',
  standalone: true
})
export class TooltipDirective implements OnInit, OnDestroy {

  // Habilita as tooltips do Bootstrap (vêm desativadas por padrão)
  // https://getbootstrap.com/docs/5.0/components/tooltips/

  private tooltip!: Tooltip;

  constructor(private el: ElementRef) {
    this.el.nativeElement.setAttribute('data-bs-toggle', 'tooltip');
  }

  ngOnInit() {
    this.tooltip = new bootstrap.Tooltip(this.el.nativeElement);
  }

  ngOnDestroy() {
    this.tooltip?.dispose();
  }
}
