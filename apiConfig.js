// API Configuration and Authentication Helpers
import AsyncStorage from '@react-native-async-storage/async-storage';

// Replace with your actual Laravel app URL
export const API_BASE_URL = 'http://your-laravel-app.com/api';

// Authentication token management
export const getAuthToken = async () => {
  try {
    return await AsyncStorage.getItem('auth_token');
  } catch (error) {
    console.error('Error getting auth token:', error);
    return null;
  }
};

export const setAuthToken = async (token) => {
  try {
    await AsyncStorage.setItem('auth_token', token);
  } catch (error) {
    console.error('Error setting auth token:', error);
  }
};

export const removeAuthToken = async () => {
  try {
    await AsyncStorage.removeItem('auth_token');
  } catch (error) {
    console.error('Error removing auth token:', error);
  }
};

// API request helper
export const apiRequest = async (endpoint, options = {}) => {
  try {
    const token = await getAuthToken();
    
    const defaultHeaders = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (token) {
      defaultHeaders['Authorization'] = `Bearer ${token}`;
    }

    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
      ...options,
      headers: {
        ...defaultHeaders,
        ...options.headers,
      },
    });

    if (!response.ok) {
      if (response.status === 401) {
        // Token expired or invalid
        await removeAuthToken();
        throw new Error('Authentication failed');
      }
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    return await response.json();
  } catch (error) {
    console.error('API request error:', error);
    throw error;
  }
};

// Specific API functions
export const fetchMembershipData = async () => {
  return await apiRequest('/mobile/active-membership');
};

export const loginUser = async (credentials) => {
  const response = await fetch(`${API_BASE_URL}/mobile/login`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: JSON.stringify(credentials),
  });

  if (!response.ok) {
    throw new Error('Login failed');
  }

  const data = await response.json();
  
  if (data.token) {
    await setAuthToken(data.token);
  }

  return data;
};

export const logoutUser = async () => {
  try {
    await apiRequest('/mobile/logout', { method: 'POST' });
  } catch (error) {
    console.error('Logout error:', error);
  } finally {
    await removeAuthToken();
  }
}; 