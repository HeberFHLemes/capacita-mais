import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ContatoSection } from './contato-section';

describe('ContatoSection', () => {
  let component: ContatoSection;
  let fixture: ComponentFixture<ContatoSection>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ContatoSection]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ContatoSection);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
