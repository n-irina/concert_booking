import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HomePastEventComponent } from './home-past-event.component';

describe('HomePastEventComponent', () => {
  let component: HomePastEventComponent;
  let fixture: ComponentFixture<HomePastEventComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [HomePastEventComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(HomePastEventComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
