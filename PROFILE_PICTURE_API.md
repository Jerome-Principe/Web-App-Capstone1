# Profile Picture Upload API Documentation

## Overview

This document describes the API endpoints for handling profile picture uploads in the mobile application.

## API Endpoints

### 1. Upload Profile Picture

**POST** `/api/mobile/upload/profile-image`

Uploads a profile picture for the authenticated user.

**Headers:**

```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Body (FormData):**

```
profileImage: [file] (required)
```

**Supported file types:** jpeg, png, jpg, gif
**Maximum file size:** 5MB

**Response (Success - 200):**

```json
{
    "success": true,
    "message": "Profile image uploaded successfully",
    "imageUrl": "https://yourdomain.com/uploads/profile_pictures/profile_1_1234567890.jpg",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "profileImageUrl": "https://yourdomain.com/uploads/profile_pictures/profile_1_1234567890.jpg"
    }
}
```

**Response (Error - 422):**

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "profileImage": ["The profile image field is required."]
    }
}
```

### 2. Get User Profile

**GET** `/api/mobile/profile`

Retrieves the current user's profile information including profile picture URL.

**Headers:**

```
Authorization: Bearer {token}
```

**Response (Success - 200):**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "profileImageUrl": "https://yourdomain.com/uploads/profile_pictures/profile_1_1234567890.jpg"
    }
}
```

### 3. Delete Profile Picture

**DELETE** `/api/mobile/profile/image`

Deletes the current user's profile picture.

**Headers:**

```
Authorization: Bearer {token}
```

**Response (Success - 200):**

```json
{
    "success": true,
    "message": "Profile image deleted successfully"
}
```

## React Native Implementation

### Upload Profile Picture

```javascript
const uploadProfileImage = async (uri) => {
    try {
        const authToken = await AsyncStorage.getItem("authtoken");

        const formData = new FormData();
        formData.append("profileImage", {
            uri,
            name: `profile_${Date.now()}.jpg`,
            type: "image/jpeg",
        });

        const response = await axios.post(
            `${API_BASE_URL}/api/mobile/upload/profile-image`,
            formData,
            {
                headers: {
                    Authorization: `Bearer ${authToken}`,
                    "Content-Type": "multipart/form-data",
                },
            }
        );

        if (response.data.success) {
            const downloadUrl = response.data.imageUrl;
            setProfileImageUrl(downloadUrl);
            Alert.alert("Success", "Profile image updated successfully.");
        }
    } catch (error) {
        console.error("Error uploading image:", error);
        Alert.alert("Error", "Failed to upload image. Please try again.");
    }
};
```

### Get User Profile

```javascript
const fetchProfileDetails = async () => {
    try {
        const authToken = await AsyncStorage.getItem("authtoken");

        const response = await axios.get(`${API_BASE_URL}/api/mobile/user`, {
            headers: { Authorization: `Bearer ${authToken}` },
        });

        const userData = response.data;
        setProfileImageUrl(userData.profileImageUrl || null);
    } catch (error) {
        console.error("Error fetching profile details:", error);
    }
};
```

## File Storage

Profile pictures are stored in the `public/uploads/profile_pictures/` directory with the following naming convention:

-   Format: `profile_{user_id}_{timestamp}.{extension}`
-   Example: `profile_1_1234567890.jpg`

## Security Features

1. **Authentication Required:** All endpoints require a valid Bearer token
2. **File Validation:** Only image files (jpeg, png, jpg, gif) are accepted
3. **File Size Limit:** Maximum 5MB per file
4. **Unique Filenames:** Prevents filename conflicts
5. **User Isolation:** Users can only upload/delete their own profile pictures

## Error Handling

The API returns appropriate HTTP status codes:

-   `200`: Success
-   `400`: Bad Request (no file provided)
-   `401`: Unauthorized (invalid/missing token)
-   `422`: Validation Error (invalid file type/size)
-   `500`: Server Error

## Database Schema

The `users` table includes a `profile_picture` column:

```sql
ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) NULL;
```

This column stores the relative path to the uploaded image file.
