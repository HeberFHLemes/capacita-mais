import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MissaoSection } from './missao-section';

describe('MissaoSection', () => {
  let component: MissaoSection;
  let fixture: ComponentFixture<MissaoSection>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [MissaoSection]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MissaoSection);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
