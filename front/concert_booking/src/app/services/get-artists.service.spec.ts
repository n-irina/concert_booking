import { TestBed } from '@angular/core/testing';

import { GetArtistsService } from '../get-artists.service';

describe('GetArtistsService', () => {
  let service: GetArtistsService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(GetArtistsService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
