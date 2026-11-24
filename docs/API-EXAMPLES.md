# API examples

Base URL: `http://127.0.0.1:8000/api`

## Create sample record

```http
POST /links
Accept: application/json
Content-Type: application/json

{
  "slug": "product-guide",
  "label": "Product guide",
  "target_url": "https://example.com/guide",
  "clicks": 42,
  "is_active": true
}
```

## Validation

Submit an empty object and the API responds with HTTP 422 and field-level validation errors.
