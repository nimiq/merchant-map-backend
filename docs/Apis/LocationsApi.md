# LocationsApi

All URIs are relative to *http://localhost*

| Method | HTTP request | Description |
|------------- | ------------- | -------------|
| [**searchLocations**](LocationsApi.md#searchLocations) | **GET** /api/search | search |


<a name="searchLocations"></a>
# **searchLocations**
> SearchLocationsResponse searchLocations(filter\[city\], filter\[country\], filter\[description\], filter\[email\], filter\[label\], filter\[address\_line\_1\], filter\[address\_line\_2\], filter\[address\_line\_3\], filter\[number\], filter\[website\], filter\[zip\], filter\[bounding\_box\], filter\[limit\], filter\[digital\_goods\])

search

### Parameters

|Name | Type | Description  | Notes |
|------------- | ------------- | ------------- | -------------|
| **filter\[city\]** | **String**|  | [optional] [default to null] |
| **filter\[country\]** | **String**|  | [optional] [default to null] |
| **filter\[description\]** | **String**|  | [optional] [default to null] |
| **filter\[email\]** | **String**|  | [optional] [default to null] |
| **filter\[label\]** | **String**|  | [optional] [default to null] |
| **filter\[address\_line\_1\]** | **String**|  | [optional] [default to null] |
| **filter\[address\_line\_2\]** | **String**|  | [optional] [default to null] |
| **filter\[address\_line\_3\]** | **String**|  | [optional] [default to null] |
| **filter\[number\]** | **BigDecimal**|  | [optional] [default to null] |
| **filter\[website\]** | **String**|  | [optional] [default to null] |
| **filter\[zip\]** | **String**|  | [optional] [default to null] |
| **filter\[bounding\_box\]** | **String**| SW longitude, SW latitude, NE longitude, NE latitude | [optional] [default to null] |
| **filter\[limit\]** | **BigDecimal**|  | [optional] [default to null] |
| **filter\[digital\_goods\]** | **Boolean**|  | [optional] [default to null] |

### Return type

[**SearchLocationsResponse**](../Models/SearchLocationsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

