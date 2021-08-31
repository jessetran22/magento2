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
 * @Title("MC-21996: Customer can login if product in his cart was disabled")
 * @Description("Customer can login with disabled product in the cart and a coupon applied<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCustomerCheckoutDisabledProductAndCouponTest.xml<br>")
 * @TestCaseId("MC-21996")
 * @group checkout
 */
class StorefrontCustomerCheckoutDisabledProductAndCouponTestCest
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
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->createEntity("createUSCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createUSCustomer
		$I->comment("Create sales rule with coupon");
		$I->createEntity("createSalesRule", "hook", "SalesRuleSpecificCouponAndByPercent", [], []); // stepKey: createSalesRule
		$I->createEntity("createCouponForCartPriceRule", "hook", "SimpleSalesRuleCoupon", ["createSalesRule"], []); // stepKey: createCouponForCartPriceRule
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createUSCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createSalesRule", "hook"); // stepKey: deleteSalesRule
		$I->comment("Entering Action Group [navigateToProductListing] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductListing
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductListing
		$I->comment("Exiting Action Group [navigateToProductListing] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetGridToDefaultKeywordSearch
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetGridToDefaultKeywordSearch
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetGridToDefaultKeywordSearch
		$I->comment("Exiting Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
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
	 * @Stories({"Checkout via the Storefront"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerCheckoutDisabledProductAndCouponTest(AcceptanceTester $I)
	{
		$I->comment("Login as Customer");
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('createUSCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('createUSCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->comment("Add product to shopping cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnSimpleProductPage
		$I->comment("Entering Action Group [cartAddSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartAddSimpleProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartCartAddSimpleProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartAddSimpleProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartAddSimpleProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartAddSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartAddSimpleProductToCart
		$I->comment("Exiting Action Group [cartAddSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Open View and edit");
		$I->comment("Entering Action Group [clickMiniCart1] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartClickMiniCart1
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartClickMiniCart1WaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartClickMiniCart1
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleClickMiniCart1
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleClickMiniCart1WaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartClickMiniCart1
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartClickMiniCart1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickMiniCart1
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlClickMiniCart1
		$I->comment("Exiting Action Group [clickMiniCart1] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Fill the Estimate Shipping and Tax section");
		$I->comment("Entering Action Group [fillEstimateShippingAndTaxFields] CheckoutFillEstimateShippingAndTaxActionGroup");
		$I->conditionalClick("#block-shipping-heading", "#block-summary", false); // stepKey: openShippingDetailsFillEstimateShippingAndTaxFields
		$I->waitForElementVisible("select[name='country_id']", 30); // stepKey: waitForSummarySectionLoadFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: waitForSummarySectionLoadFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->selectOption("select[name='country_id']", "US"); // stepKey: selectCountryFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectCountryFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->selectOption("select[name='region_id']", "Texas"); // stepKey: selectStateFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectStateFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->waitForElementVisible("input[name='postcode']", 30); // stepKey: waitForPostCodeVisibleFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: waitForPostCodeVisibleFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->fillField("input[name='postcode']", "78729"); // stepKey: selectPostCodeFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectPostCodeFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDiappearFillEstimateShippingAndTaxFields
		$I->comment("Exiting Action Group [fillEstimateShippingAndTaxFields] CheckoutFillEstimateShippingAndTaxActionGroup");
		$I->comment("Apply Coupon");
		$I->comment("Entering Action Group [applyDiscount] StorefrontApplyCouponActionGroup");
		$I->waitForElement("#block-discount-heading", 30); // stepKey: waitForCouponHeaderApplyDiscount
		$I->conditionalClick("#block-discount-heading", ".block.discount.active", false); // stepKey: clickCouponHeaderApplyDiscount
		$I->waitForElementVisible("#coupon_code", 30); // stepKey: waitForCouponFieldApplyDiscount
		$I->fillField("#coupon_code", $I->retrieveEntityField('createCouponForCartPriceRule', 'code', 'test')); // stepKey: fillCouponFieldApplyDiscount
		$I->click("#discount-coupon-form button[class*='apply']"); // stepKey: clickApplyButtonApplyDiscount
		$I->waitForPageLoad(30); // stepKey: clickApplyButtonApplyDiscountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadApplyDiscount
		$I->comment("Exiting Action Group [applyDiscount] StorefrontApplyCouponActionGroup");
		$I->comment("Sign out Customer from storefront");
		$I->comment("Entering Action Group [customerLogout] StorefrontSignOutActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonCustomerLogout
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCustomerLogout
		$I->see("You are signed out"); // stepKey: signOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontSignOutActionGroup");
		$I->comment("Login to admin panel");
		$I->openNewTab(); // stepKey: openNewTab
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Find the first simple product that we just created using the product grid and go to its page");
		$I->comment("Entering Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Disabled simple product from grid");
		$I->comment("Entering Action Group [disabledProductFromGrid] ChangeStatusProductUsingProductGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDisabledProductFromGrid
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDisabledProductFromGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDisabledProductFromGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDisabledProductFromGrid
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterDisabledProductFromGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDisabledProductFromGridWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDisabledProductFromGrid
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDisabledProductFromGrid
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDisabledProductFromGrid
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDisabledProductFromGridWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Change status']"); // stepKey: clickChangeStatusActionDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickChangeStatusActionDisabledProductFromGridWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-menu-item')]//ul/li/span[text() = 'Disable']"); // stepKey: clickChangeStatusDisabledDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: waitForStatusToBeChangedDisabledProductFromGrid
		$I->see("A total of 1 record(s) have been updated.", "#messages div.message-success"); // stepKey: seeSuccessMessageDisabledProductFromGrid
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForMaskToDisappearDisabledProductFromGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitial2DisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitial2DisabledProductFromGridWaitForPageLoad
		$I->comment("Exiting Action Group [disabledProductFromGrid] ChangeStatusProductUsingProductGridActionGroup");
		$I->closeTab(); // stepKey: closeTab
		$I->comment("Login as Customer");
		$I->comment("Entering Action Group [customerLoginSecondTime] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLoginSecondTime
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLoginSecondTime
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLoginSecondTime
		$I->fillField("#email", $I->retrieveEntityField('createUSCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLoginSecondTime
		$I->fillField("#pass", $I->retrieveEntityField('createUSCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLoginSecondTime
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLoginSecondTime
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginSecondTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLoginSecondTime
		$I->comment("Exiting Action Group [customerLoginSecondTime] LoginToStorefrontActionGroup");
		$I->comment("Check cart");
		$I->click("a.showcart"); // stepKey: clickMiniCart2
		$I->waitForPageLoad(60); // stepKey: clickMiniCart2WaitForPageLoad
		$I->dontSeeElement("span.counter-number"); // stepKey: dontSeeCartItem
	}
}
