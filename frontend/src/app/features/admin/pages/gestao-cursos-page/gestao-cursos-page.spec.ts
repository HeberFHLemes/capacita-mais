import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GestaoCursosPage } from './gestao-cursos-page';

describe('GestaoCursosPage', () => {
  let component: GestaoCursosPage;
  let fixture: ComponentFixture<GestaoCursosPage>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [GestaoCursosPage]
    })
    .compileComponents();

    fixture = TestBed.createComponent(GestaoCursosPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
