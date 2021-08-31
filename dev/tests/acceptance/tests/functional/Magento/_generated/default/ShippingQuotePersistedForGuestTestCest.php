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
 * @Title("MAGETWO-99025: Estimate Shipping and Tax block sections on shipping cart saving correctly for Guest.")
 * @Description("Verify that 'Estimate Shipping and Tax' block sections on shipping cart saving correctly for Guest after switching to another page. And check that the shopping cart is cleared after reset persistent cookie.<h3>Test files</h3>app/code/Magento/Persistent/Test/Mftf/Test/ShippingQuotePersistedForGuestTest.xml<br>")
 * @TestCaseId("MAGETWO-99025")
 * @group persistent
 */
class ShippingQuotePersistedForGuestTestCest
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
		$I->comment("Enabled The Persistent Shopping Cart feature");
		$I->createEntity("enablePersistent", "hook", "PersistentConfigEnabled", [], []); // stepKey: enablePersistent
		$I->createEntity("persistentLogoutClearDisable", "hook", "PersistentLogoutClearDisable", [], []); // stepKey: persistentLogoutClearDisable
		$I->comment("Create simple product");
		$createProductFields['price'] = "150";
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], $createProductFields); // stepKey: createProduct
		$I->comment("Create customer");
		$createCustomerFields['firstname'] = "John1";
		$createCustomerFields['lastname'] = "Doe1";
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], $createCustomerFields); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Revert persistent configuration to default");
		$I->createEntity("setDefaultPersistentState", "hook", "PersistentConfigDefault", [], []); // stepKey: setDefaultPersistentState
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"Persistent"})
	 * @Stories({"Guest checkout"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ShippingQuotePersistedForGuestTest(AcceptanceTester $I)
	{
		$I->comment("Step 1: Login as a Customer with remember me checked");
		$I->comment("Entering Action Group [loginToStorefrontAccountWithRememberMeChecked] CustomerLoginOnStorefrontWithRememberMeCheckedActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccountWithRememberMeChecked
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccountWithRememberMeChecked
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccountWithRememberMeChecked
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccountWithRememberMeChecked
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccountWithRememberMeChecked
		$I->checkOption("[name='persistent_remember_me']"); // stepKey: checkRememberMeLoginToStorefrontAccountWithRememberMeChecked
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWithRememberMeChecked
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWithRememberMeCheckedWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccountWithRememberMeChecked
		$I->comment("Exiting Action Group [loginToStorefrontAccountWithRememberMeChecked] CustomerLoginOnStorefrontWithRememberMeCheckedActionGroup");
		$I->comment("Step 2: Open the Product Page and add the product to shopping cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageAsLoggedUser
		$I->comment("Entering Action Group [addProductToCartAsLoggedUser] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCartAsLoggedUser
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCartAsLoggedUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProductToCartAsLoggedUser
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCartAsLoggedUser
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCartAsLoggedUser
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCartAsLoggedUser
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCartAsLoggedUser
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCartAsLoggedUser
		$I->comment("Exiting Action Group [addProductToCartAsLoggedUser] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Step 3: Log out, reset persistent cookie and go to homepage");
		$I->amOnPage("/customer/account/logout/"); // stepKey: signOut
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitSignOutPage
		$I->resetCookie("persistent_shopping_cart"); // stepKey: resetPersistentCookie
		$I->comment("Entering Action Group [amOnHomePageAfterResetPersistentCookie] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnHomePageAfterResetPersistentCookie
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnHomePageAfterResetPersistentCookie
		$I->comment("Exiting Action Group [amOnHomePageAfterResetPersistentCookie] StorefrontOpenHomePageActionGroup");
		$I->comment("Step 4: Add the product to shopping cart and open cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageAsGuestUser
		$I->comment("Entering Action Group [addProductToCartAsGuestUser] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCartAsGuestUser
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCartAsGuestUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProductToCartAsGuestUser
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCartAsGuestUser
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCartAsGuestUser
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCartAsGuestUser
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCartAsGuestUser
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCartAsGuestUser
		$I->comment("Exiting Action Group [addProductToCartAsGuestUser] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [goToShoppingCartBeforeChangeShippingAndTaxSection] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToShoppingCartBeforeChangeShippingAndTaxSection
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToShoppingCartBeforeChangeShippingAndTaxSectionWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToShoppingCartBeforeChangeShippingAndTaxSection
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartBeforeChangeShippingAndTaxSection
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartBeforeChangeShippingAndTaxSectionWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToShoppingCartBeforeChangeShippingAndTaxSection
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToShoppingCartBeforeChangeShippingAndTaxSectionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToShoppingCartBeforeChangeShippingAndTaxSection
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToShoppingCartBeforeChangeShippingAndTaxSection
		$I->comment("Exiting Action Group [goToShoppingCartBeforeChangeShippingAndTaxSection] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Step 5: Open Estimate Shipping and Tax block and fill the sections");
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: expandEstimateShippingAndTax
		$I->waitForPageLoad(10); // stepKey: expandEstimateShippingAndTaxWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectUSCountry
		$I->waitForPageLoad(10); // stepKey: selectUSCountryWaitForPageLoad
		$I->selectOption("select[name='region_id']", "California"); // stepKey: selectCaliforniaRegion
		$I->waitForPageLoad(10); // stepKey: selectCaliforniaRegionWaitForPageLoad
		$I->fillField("input[name='postcode']", "90001"); // stepKey: inputPostCode
		$I->waitForPageLoad(10); // stepKey: inputPostCodeWaitForPageLoad
		$I->comment("Step 6: Go to Homepage");
		$I->comment("Entering Action Group [goToHomePageAfterChangingShippingAndTaxSection] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePageAfterChangingShippingAndTaxSection
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePageAfterChangingShippingAndTaxSection
		$I->comment("Exiting Action Group [goToHomePageAfterChangingShippingAndTaxSection] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [goToShoppingCartAfterChangingShippingAndTaxSection] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToShoppingCartAfterChangingShippingAndTaxSection
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToShoppingCartAfterChangingShippingAndTaxSectionWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToShoppingCartAfterChangingShippingAndTaxSection
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartAfterChangingShippingAndTaxSection
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartAfterChangingShippingAndTaxSectionWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToShoppingCartAfterChangingShippingAndTaxSection
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToShoppingCartAfterChangingShippingAndTaxSectionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToShoppingCartAfterChangingShippingAndTaxSection
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToShoppingCartAfterChangingShippingAndTaxSection
		$I->comment("Exiting Action Group [goToShoppingCartAfterChangingShippingAndTaxSection] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Step 7: Go to shopping cart and check \"Estimate Shipping and Tax\" fields values are saved");
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: expandEstimateShippingAndTaxAfterChanging
		$I->waitForPageLoad(10); // stepKey: expandEstimateShippingAndTaxAfterChangingWaitForPageLoad
		$I->seeOptionIsSelected("select[name='country_id']", "United States"); // stepKey: checkCustomerCountry
		$I->waitForPageLoad(10); // stepKey: checkCustomerCountryWaitForPageLoad
		$I->seeOptionIsSelected("select[name='region_id']", "California"); // stepKey: checkCustomerRegion
		$I->waitForPageLoad(10); // stepKey: checkCustomerRegionWaitForPageLoad
		$grabTextPostCode = $I->grabValueFrom("input[name='postcode']"); // stepKey: grabTextPostCode
		$I->waitForPageLoad(10); // stepKey: grabTextPostCodeWaitForPageLoad
		$I->assertEquals("90001", $grabTextPostCode, "Customer postcode is invalid"); // stepKey: checkCustomerPostcode
	}
}
