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
 * @Title("#: Shipping address is not validated in checkout when proceeding step as logged in user with default shipping address")
 * @Description("Shouldn't be able to place an order as a customer without state if it's required.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCustomerCheckoutWithoutRegionTest.xml<br>")
 * @TestCaseId("#")
 * @group checkout
 */
class StorefrontCustomerCheckoutWithoutRegionTestCest
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
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_GB_Customer", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Entering Action Group [setCustomCountryWithRequiredRegion] SelectCountriesWithRequiredRegionActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: navigateToAdminConfigGeneralPageSetCustomCountryWithRequiredRegion
		$I->conditionalClick("#general_region-head", "#general_region_state_required", false); // stepKey: expandStateOptionsTabSetCustomCountryWithRequiredRegion
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxSetCustomCountryWithRequiredRegion
		$I->scrollTo("#general_region_state_required"); // stepKey: scrollToFormSetCustomCountryWithRequiredRegion
		$I->selectOption("#general_region_state_required", ["United Kingdom"]); // stepKey: selectCountriesWithRequiredRegionSetCustomCountryWithRequiredRegion
		$I->click("#save"); // stepKey: saveConfigSetCustomCountryWithRequiredRegion
		$I->waitForPageLoad(30); // stepKey: waitForSavingConfigSetCustomCountryWithRequiredRegion
		$I->comment("Exiting Action Group [setCustomCountryWithRequiredRegion] SelectCountriesWithRequiredRegionActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [setDefaultCountriesWithRequiredRegion] SelectCountriesWithRequiredRegionActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: navigateToAdminConfigGeneralPageSetDefaultCountriesWithRequiredRegion
		$I->conditionalClick("#general_region-head", "#general_region_state_required", false); // stepKey: expandStateOptionsTabSetDefaultCountriesWithRequiredRegion
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxSetDefaultCountriesWithRequiredRegion
		$I->scrollTo("#general_region_state_required"); // stepKey: scrollToFormSetDefaultCountriesWithRequiredRegion
		$I->selectOption("#general_region_state_required", ["Australia", "Brazil", "Canada", "Croatia", "Estonia", "India", "Latvia", "Lithuania", "Romania", "Spain", "Switzerland", "United States", "Australia"]); // stepKey: selectCountriesWithRequiredRegionSetDefaultCountriesWithRequiredRegion
		$I->click("#save"); // stepKey: saveConfigSetDefaultCountriesWithRequiredRegion
		$I->waitForPageLoad(30); // stepKey: waitForSavingConfigSetDefaultCountriesWithRequiredRegion
		$I->comment("Exiting Action Group [setDefaultCountriesWithRequiredRegion] SelectCountriesWithRequiredRegionActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Checkout via the Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerCheckoutWithoutRegionTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [navigateToCheckoutPage] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityNavigateToCheckoutPage
		$I->wait(5); // stepKey: waitMinicartRenderingNavigateToCheckoutPage
		$I->click("a.showcart"); // stepKey: clickCartNavigateToCheckoutPage
		$I->waitForPageLoad(60); // stepKey: clickCartNavigateToCheckoutPageWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutNavigateToCheckoutPage
		$I->waitForPageLoad(30); // stepKey: goToCheckoutNavigateToCheckoutPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToCheckoutPage] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Entering Action Group [clickNextButton] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNextButton
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextButtonWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickNextButton
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickNextButtonWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNextButton
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextButtonWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickNextButton
		$I->comment("Exiting Action Group [clickNextButton] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->see("Please specify a regionId in shipping address.", "div.message-error.error.message"); // stepKey: seeErrorMessages
	}
}
