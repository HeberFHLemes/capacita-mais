import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GestaoCursoCard } from './gestao-curso-card';

describe('GestaoCursoCard', () => {
  let component: GestaoCursoCard;
  let fixture: ComponentFixture<GestaoCursoCard>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [GestaoCursoCard]
    })
    .compileComponents();

    fixture = TestBed.createComponent(GestaoCursoCard);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
