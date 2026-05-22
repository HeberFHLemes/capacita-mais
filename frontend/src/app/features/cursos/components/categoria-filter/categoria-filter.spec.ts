import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CategoriaFilter } from './categoria-filter';

describe('CategoriaFilter', () => {
  let component: CategoriaFilter;
  let fixture: ComponentFixture<CategoriaFilter>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CategoriaFilter]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CategoriaFilter);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
