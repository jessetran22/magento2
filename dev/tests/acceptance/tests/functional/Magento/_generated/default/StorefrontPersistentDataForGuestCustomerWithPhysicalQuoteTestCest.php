<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-13479: Persistent Data for Guest Customer with physical quote")
 * @Description("One can use Persistent Data for Guest Customer with physical quote<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontPersistentDataForGuestCustomerWithPhysicalQuoteTest.xml<br>")
 * @TestCaseId("MC-13479")
 * @group checkout
 */
class StorefrontPersistentDataForGuestCustomerWithPhysicalQuoteTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$createProductFields['price'] = "10";
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], $createProductFields); // stepKey: createProduct
		$I->createEntity("enableFreeShipping", "hook", "FreeShippinMethodConfig", [], []); // stepKey: enableFreeShipping
		$I->comment("Entering Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefront
		$I->comment("Exiting Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$clearLocalStorage = $I->executeJS("window.localStorage.clear();"); // stepKey: clearLocalStorage
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->createEntity("disableFreeShipping", "hook", "FreeShippinMethodDefault", [], []); // stepKey: disableFreeShipping
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Checkout"})
	 * @Stories({"Checkout via Guest Checkout"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontPersistentDataForGuestCustomerWithPhysicalQuoteTest(AcceptanceTester $I)
	{
		$I->comment("1. Add simple product to cart and go to checkout");
		$I->comment("Entering Action Group [addSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSimpleProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddSimpleProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSimpleProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSimpleProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSimpleProductToCart
		$I->comment("Exiting Action Group [addSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("2. Go to Shopping Cart");
		$I->comment("Entering Action Group [goToCheckoutCartIndexPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCheckoutCartIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCheckoutCartIndexPage
		$I->comment("Exiting Action Group [goToCheckoutCartIndexPage] StorefrontCartPageOpenActionGroup");
		$I->comment("3. Open \"Estimate Shipping and Tax\" section and input data");
		$I->comment("Entering Action Group [fillEstimateShippingAndTaxSection] StorefrontCartEstimateShippingAndTaxActionGroup");
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: clickOnEstimateShippingAndTaxFillEstimateShippingAndTaxSection
		$I->waitForPageLoad(10); // stepKey: clickOnEstimateShippingAndTaxFillEstimateShippingAndTaxSectionWaitForPageLoad
		$I->waitForElementVisible("select[name='country_id']", 30); // stepKey: waitForCountrySelectorIsVisibleFillEstimateShippingAndTaxSection
		$I->waitForPageLoad(10); // stepKey: waitForCountrySelectorIsVisibleFillEstimateShippingAndTaxSectionWaitForPageLoad
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectCountryFillEstimateShippingAndTaxSection
		$I->waitForPageLoad(10); // stepKey: selectCountryFillEstimateShippingAndTaxSectionWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCountryLoadingMaskDisappearFillEstimateShippingAndTaxSection
		$I->selectOption("select[name='region_id']", "California"); // stepKey: selectStateProvinceFillEstimateShippingAndTaxSection
		$I->waitForPageLoad(10); // stepKey: selectStateProvinceFillEstimateShippingAndTaxSectionWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForStateLoadingMaskDisappearFillEstimateShippingAndTaxSection
		$I->fillField("input[name='postcode']", "90240"); // stepKey: fillZipPostalCodeFieldFillEstimateShippingAndTaxSection
		$I->waitForPageLoad(10); // stepKey: fillZipPostalCodeFieldFillEstimateShippingAndTaxSectionWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForZipLoadingMaskDisappearFillEstimateShippingAndTaxSection
		$I->comment("Exiting Action Group [fillEstimateShippingAndTaxSection] StorefrontCartEstimateShippingAndTaxActionGroup");
		$I->comment("Entering Action Group [assertShippingMethodFlatRateIsPresentInCart] StorefrontAssertShippingMethodPresentInCartActionGroup");
		$I->see("Flat Rate", "#co-shipping-method-form dl dt span"); // stepKey: assertShippingMethodIsPresentInCartAssertShippingMethodFlatRateIsPresentInCart
		$I->comment("Exiting Action Group [assertShippingMethodFlatRateIsPresentInCart] StorefrontAssertShippingMethodPresentInCartActionGroup");
		$I->comment("Entering Action Group [assertShippingMethodFreeShippingIsPresentInCart] StorefrontAssertShippingMethodPresentInCartActionGroup");
		$I->see("Free Shipping", "#co-shipping-method-form dl dt span"); // stepKey: assertShippingMethodIsPresentInCartAssertShippingMethodFreeShippingIsPresentInCart
		$I->comment("Exiting Action Group [assertShippingMethodFreeShippingIsPresentInCart] StorefrontAssertShippingMethodPresentInCartActionGroup");
		$I->comment("4. Select Flat Rate as shipping");
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: selectFlatRateShippingMethodWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAfterFlatRateSelection
		$I->see("15", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertOrderTotalField
		$I->comment("5. Refresh browser page (F5)");
		$I->comment("Entering Action Group [reloadPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadPage
		$I->comment("Exiting Action Group [reloadPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->comment("Entering Action Group [assertCartEstimateShippingAndTaxAfterPageReload] StorefrontAssertCartEstimateShippingAndTaxActionGroup");
		$I->seeInField("select[name='country_id']", "United States"); // stepKey: assertCountryFieldInCartEstimateShippingAndTaxSectionAssertCartEstimateShippingAndTaxAfterPageReload
		$I->waitForPageLoad(10); // stepKey: assertCountryFieldInCartEstimateShippingAndTaxSectionAssertCartEstimateShippingAndTaxAfterPageReloadWaitForPageLoad
		$I->seeInField("input[name='region']", "California"); // stepKey: assertStateProvinceInCartEstimateShippingAndTaxSectionAssertCartEstimateShippingAndTaxAfterPageReload
		$I->seeInField("input[name='postcode']", "90240"); // stepKey: assertZipPostalCodeInCartEstimateShippingAndTaxSectionAssertCartEstimateShippingAndTaxAfterPageReload
		$I->waitForPageLoad(10); // stepKey: assertZipPostalCodeInCartEstimateShippingAndTaxSectionAssertCartEstimateShippingAndTaxAfterPageReloadWaitForPageLoad
		$I->comment("Exiting Action Group [assertCartEstimateShippingAndTaxAfterPageReload] StorefrontAssertCartEstimateShippingAndTaxActionGroup");
		$I->comment("Entering Action Group [assertFlatRateShippingMethodIsChecked] StorefrontAssertCartShippingMethodSelectedActionGroup");
		$I->seeCheckboxIsChecked("#s_method_flatrate_flatrate"); // stepKey: assertShippingMethodIsCheckedAssertFlatRateShippingMethodIsChecked
		$I->waitForPageLoad(30); // stepKey: assertShippingMethodIsCheckedAssertFlatRateShippingMethodIsCheckedWaitForPageLoad
		$I->comment("Exiting Action Group [assertFlatRateShippingMethodIsChecked] StorefrontAssertCartShippingMethodSelectedActionGroup");
		$I->comment("6. Go to Checkout");
		$I->comment("Entering Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutClickProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutClickProceedToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickProceedToCheckout
		$I->comment("Exiting Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Entering Action Group [assertCheckoutEstimateShippingInformationAfterGoingToCheckout] StorefrontAssertCheckoutEstimateShippingInformationActionGroup");
		$I->seeInField("select[name=country_id]", "United States"); // stepKey: assertCountryFieldAssertCheckoutEstimateShippingInformationAfterGoingToCheckout
		$I->seeInField("select[name=region_id]", "California"); // stepKey: assertStateProvinceFieldAssertCheckoutEstimateShippingInformationAfterGoingToCheckout
		$I->seeInField("input[name=postcode]", "90240"); // stepKey: assertZipPostalCodeFieldAssertCheckoutEstimateShippingInformationAfterGoingToCheckout
		$I->comment("Exiting Action Group [assertCheckoutEstimateShippingInformationAfterGoingToCheckout] StorefrontAssertCheckoutEstimateShippingInformationActionGroup");
		$I->comment("Entering Action Group [assertFlatRateShippingMethodIsCheckedAfterGoingToCheckout] StorefrontAssertCheckoutShippingMethodSelectedActionGroup");
		$I->seeCheckboxIsChecked("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: assertShippingMethodByNameIsCheckedAssertFlatRateShippingMethodIsCheckedAfterGoingToCheckout
		$I->comment("Exiting Action Group [assertFlatRateShippingMethodIsCheckedAfterGoingToCheckout] StorefrontAssertCheckoutShippingMethodSelectedActionGroup");
		$I->comment("7. Change  persisted data");
		$I->selectOption("select[name=country_id]", "United Kingdom"); // stepKey: changeCountryField
		$I->fillField("input[name=region]", ""); // stepKey: changeStateProvinceField
		$I->fillField("input[name=postcode]", "KW1 7NQ"); // stepKey: changeZipPostalCodeField
		$I->comment("8. Change shipping rate, select Free Shipping");
		$I->checkOption("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/..//input"); // stepKey: checkFreeShippingAsShippingMethod
		$I->comment("9. Fill other fields");
		$I->comment("Entering Action Group [fillOtherFieldsInCheckoutShippingSection] StorefrontFillGuestShippingInfoActionGroup");
		$I->fillField("#customer-email", "johndoe@example.com"); // stepKey: fillEmailAddressFieldFillOtherFieldsInCheckoutShippingSection
		$I->fillField("input[name=firstname]", "John"); // stepKey: fillFirstNameFieldFillOtherFieldsInCheckoutShippingSection
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: fillLastNameFieldFillOtherFieldsInCheckoutShippingSection
		$I->fillField("input[name=company]", "Test Company"); // stepKey: fillCompanyFieldFillOtherFieldsInCheckoutShippingSection
		$I->fillField("input[name='street[0]']", "39 St Maurices Road"); // stepKey: fillStreetAddressFirstLineFieldFillOtherFieldsInCheckoutShippingSection
		$I->fillField("input[name='street[1]']", "ap. 654"); // stepKey: fillStreetAddressSecondLineFieldFillOtherFieldsInCheckoutShippingSection
		$I->fillField("input[name=city]", "PULDAGON"); // stepKey: fillCityFieldFillOtherFieldsInCheckoutShippingSection
		$I->fillField("input[name=telephone]", "077 5866 0667"); // stepKey: fillPhoneNumberFieldFillOtherFieldsInCheckoutShippingSection
		$I->comment("Exiting Action Group [fillOtherFieldsInCheckoutShippingSection] StorefrontFillGuestShippingInfoActionGroup");
		$I->comment("10. Refresh browser page(F5)");
		$I->comment("Entering Action Group [reloadCheckoutPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadCheckoutPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadCheckoutPage
		$I->comment("Exiting Action Group [reloadCheckoutPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->comment("Entering Action Group [assertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage] StorefrontAssertGuestShippingInfoActionGroup");
		$I->seeInField("#customer-email", "johndoe@example.com"); // stepKey: assertEmailAddressAssertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage
		$I->seeInField("input[name=firstname]", "John"); // stepKey: assertFirstNameAssertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage
		$I->seeInField("input[name=lastname]", "Doe"); // stepKey: assertLastNameAssertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage
		$I->seeInField("input[name=company]", "Test Company"); // stepKey: assertCompanyAssertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage
		$I->seeInField("input[name='street[0]']", "39 St Maurices Road"); // stepKey: assertAddressFirstLineAssertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage
		$I->seeInField("input[name='street[1]']", "ap. 654"); // stepKey: assertAddressSecondLineAssertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage
		$I->seeInField("input[name=city]", "PULDAGON"); // stepKey: assertCityAssertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage
		$I->seeInField("select[name=country_id]", "United Kingdom"); // stepKey: assertCountryAssertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage
		$I->seeInField("input[name=region]", ""); // stepKey: assertStateProvinceAssertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage
		$I->seeInField("input[name=postcode]", "KW1 7NQ"); // stepKey: assertZipPostalCodeAssertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage
		$I->seeInField("input[name=telephone]", "077 5866 0667"); // stepKey: assertPhoneNumberAssertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage
		$I->comment("Exiting Action Group [assertGuestShippingPersistedInfoAfterReloadingCheckoutShippingPage] StorefrontAssertGuestShippingInfoActionGroup");
		$I->comment("Entering Action Group [assertFreeShippingShippingMethodIsChecked] StorefrontAssertCheckoutShippingMethodSelectedActionGroup");
		$I->seeCheckboxIsChecked("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/..//input"); // stepKey: assertShippingMethodByNameIsCheckedAssertFreeShippingShippingMethodIsChecked
		$I->comment("Exiting Action Group [assertFreeShippingShippingMethodIsChecked] StorefrontAssertCheckoutShippingMethodSelectedActionGroup");
		$I->comment("11. Go back to the shopping cart");
		$I->comment("Entering Action Group [goToCheckoutCartIndexPage1] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCheckoutCartIndexPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCheckoutCartIndexPage1
		$I->comment("Exiting Action Group [goToCheckoutCartIndexPage1] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [assertCartEstimateShippingAndTaxAfterGoingBackToShoppingCart] StorefrontAssertCartEstimateShippingAndTaxActionGroup");
		$I->seeInField("select[name='country_id']", "United Kingdom"); // stepKey: assertCountryFieldInCartEstimateShippingAndTaxSectionAssertCartEstimateShippingAndTaxAfterGoingBackToShoppingCart
		$I->waitForPageLoad(10); // stepKey: assertCountryFieldInCartEstimateShippingAndTaxSectionAssertCartEstimateShippingAndTaxAfterGoingBackToShoppingCartWaitForPageLoad
		$I->seeInField("input[name='region']", ""); // stepKey: assertStateProvinceInCartEstimateShippingAndTaxSectionAssertCartEstimateShippingAndTaxAfterGoingBackToShoppingCart
		$I->seeInField("input[name='postcode']", "KW1 7NQ"); // stepKey: assertZipPostalCodeInCartEstimateShippingAndTaxSectionAssertCartEstimateShippingAndTaxAfterGoingBackToShoppingCart
		$I->waitForPageLoad(10); // stepKey: assertZipPostalCodeInCartEstimateShippingAndTaxSectionAssertCartEstimateShippingAndTaxAfterGoingBackToShoppingCartWaitForPageLoad
		$I->comment("Exiting Action Group [assertCartEstimateShippingAndTaxAfterGoingBackToShoppingCart] StorefrontAssertCartEstimateShippingAndTaxActionGroup");
		$I->comment("Entering Action Group [assertFreeShippingShippingMethodIsCheckedAfterGoingBackToShoppingCart] StorefrontAssertCartShippingMethodSelectedActionGroup");
		$I->seeCheckboxIsChecked("#s_method_freeshipping_freeshipping"); // stepKey: assertShippingMethodIsCheckedAssertFreeShippingShippingMethodIsCheckedAfterGoingBackToShoppingCart
		$I->waitForPageLoad(30); // stepKey: assertShippingMethodIsCheckedAssertFreeShippingShippingMethodIsCheckedAfterGoingBackToShoppingCartWaitForPageLoad
		$I->comment("Exiting Action Group [assertFreeShippingShippingMethodIsCheckedAfterGoingBackToShoppingCart] StorefrontAssertCartShippingMethodSelectedActionGroup");
	}
}
