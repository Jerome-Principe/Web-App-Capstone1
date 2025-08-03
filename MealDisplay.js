import React, {useState, useEffect} from 'react';
import {
  View,
  Text,
  ScrollView,
  TouchableOpacity,
  ActivityIndicator,
  Alert,
} from 'react-native';
import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';
import styles from '../../../src/style/MobileStyle/Resources/MealDisplayStyle';
import Footer from '../../../src/components/footer';
import MaterialIcons from 'react-native-vector-icons/MaterialIcons';

const MealDisplay = ({route, navigation}) => {
  const {category, type} = route.params;
  const [mealPlans, setMealPlans] = useState([]);
  const [guideline, setGuideline] = useState('');
  const [visibleDays, setVisibleDays] = useState({});
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [userId, setUserId] = useState(null);
  const [showCompleteModal, setShowCompleteModal] = useState(false);
  const [isCustomMealPlan, setIsCustomMealPlan] = useState(false);

  useEffect(() => {
    const fetchAuthTokenAndUserId = async () => {
      try {
        const authToken = await AsyncStorage.getItem('authtoken');
        if (authToken) {
          const userResponse = await axios.get(
            'https://limitlessfitnesstudio.com/api/mobile/user',
            {
              headers: {
                Authorization: `Bearer ${authToken}`,
              },
            },
          );
          const {id} = userResponse.data;
          setUserId(id);
          fetchMealPlanCustom(id, authToken);
        } else {
          setError('No auth token found');
          setLoading(false);
        }
      } catch (err) {
        setError('Failed to retrieve user data. Please try again.');
        setLoading(false);
      }
    };

    const fetchMealPlanCustom = async (userId, authToken) => {
      try {
        const response = await axios.get(
          'https://limitlessfitnesstudio.com/api/mobile/meal-plan-custom',
          {
            params: {
              user_id: userId,
              category: category,
              type: type,
            },
            headers: {
              Authorization: `Bearer ${authToken}`,
            },
          },
        );

        const {data} = response.data;

        if (data && data.length > 0) {
          setGuideline(data[0]?.guideline || 'No guideline provided');
          setMealPlans(data);
          
          // Check if this is custom meal plan data
          // Custom meal plans will have user_id field, default meal plans won't
          const isCustom = data.some(mealPlan => mealPlan?.user_id !== null && mealPlan?.user_id !== undefined);
          setIsCustomMealPlan(isCustom);
        } else {
          setError('No Meal Plan Setup!');
        }

        setLoading(false);
      } catch (err) {
        setError('Failed to fetch meal plan data. Please try again.');
        setLoading(false);
      }
    };

    fetchAuthTokenAndUserId();
  }, [category, type]);

  const toggleDayVisibility = day => {
    setVisibleDays(prev => ({
      ...prev,
      [day]: !prev[day],
    }));
  };

  if (loading) {
    return (
      <View style={styles.loading}>
        <ActivityIndicator size="large" color="#EBC755" />
        <Text style={styles.loadtxt}>Loading...</Text>
      </View>
    );
  }

  if (error) {
    return (
      <View style={styles.container}>
        <Text style={styles.errorText}>{error}</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <View style={styles.header}>
        <TouchableOpacity
          onPress={() => navigation.goBack()}
          style={styles.backButton}>
          <MaterialIcons name="arrow-back" size={24} color="black" />
        </TouchableOpacity>
        <Text style={styles.headertxt}>Meal Guide</Text>
      </View>

      <ScrollView contentContainerStyle={styles.subContainer}>
        <View style={styles.section}>
          <Text style={styles.headertxt}>{type}</Text>
          <Text style={styles.subHeader}>
            General Guidelines for the Meal Plan
          </Text>
          <Text style={styles.text}>{guideline}</Text>
        </View>

        {mealPlans.map((mealPlan, index) => (
          <View key={index} style={styles.daySection}>
            <TouchableOpacity onPress={() => toggleDayVisibility(mealPlan?.day)}>
              <Text style={styles.dayHeader}>{mealPlan?.day}</Text>
            </TouchableOpacity>
            {visibleDays[mealPlan?.day] && (
              <>
                <View>
                  <Text style={styles.headtext}>Breakfast:</Text>
                  <Text style={styles.text}>{mealPlan?.breakfast}</Text>
                </View>
                <View>
                  <Text style={styles.headtext}>Lunch:</Text>
                  <Text style={styles.text}>{mealPlan?.lunch}</Text>
                </View>
                <View>
                  <Text style={styles.headtext}>Dinner:</Text>
                  <Text style={styles.text}>{mealPlan?.dinner}</Text>
                </View>
              </>
            )}
          </View>
        ))}
      </ScrollView>

      {/* Fixed Complete Button - Only show for custom meal plans */}
      {mealPlans.length > 0 && isCustomMealPlan && (
        <View style={styles.completeBtnWrapper}>
          <TouchableOpacity
            style={styles.completeBtn}
            onPress={() => setShowCompleteModal(true)}>
            <Text style={styles.completeBtnText}>Complete</Text>
          </TouchableOpacity>
        </View>
      )}

      {/* Confirmation Modal */}
      {showCompleteModal && (
        <View style={styles.modalOverlay}>
          <View style={styles.modalContainer}>
            <Text style={styles.modalTitle}>
              Are you already finish the task?
            </Text>
            <View style={styles.modalButtonRow}>
              <TouchableOpacity
                style={styles.modalYesBtn}
                onPress={() => {
                  setShowCompleteModal(false);
                  Alert.alert('Success', 'Task marked as completed!');
                }}>
                <Text style={styles.modalBtnText}>Yes</Text>
              </TouchableOpacity>

              <TouchableOpacity
                style={styles.modalNoBtn}
                onPress={() => setShowCompleteModal(false)}>
                <Text style={styles.modalBtnText}>No</Text>
              </TouchableOpacity>
            </View>
          </View>
        </View>
      )}

      {/* Footer Section */}
      <Footer navigation={navigation} />
    </View>
  );
};

export default MealDisplay; 