import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CursoSearchBar } from './curso-search-bar';

describe('CursoSearchBar', () => {
  let component: CursoSearchBar;
  let fixture: ComponentFixture<CursoSearchBar>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CursoSearchBar]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CursoSearchBar);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
