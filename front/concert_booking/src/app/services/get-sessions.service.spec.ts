import { TestBed } from '@angular/core/testing';

import { GetSessionsService } from '../get-sessions.service';

describe('GetSessionsService', () => {
  let service: GetSessionsService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(GetSessionsService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
