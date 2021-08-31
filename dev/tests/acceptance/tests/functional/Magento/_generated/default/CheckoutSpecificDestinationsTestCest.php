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
 * @Title("MAGETWO-94195: Check that top destinations can be removed after a selection was previously saved")
 * @Description("Check that top destinations can be removed after a selection was previously saved<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/CheckoutSpecificDestinationsTest.xml<br>")
 * @TestCaseId("MAGETWO-94195")
 * @group Checkout
 */
class CheckoutSpecificDestinationsTestCest
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
		$I->createEntity("defaultCategory", "hook", "_defaultCategory", [], []); // stepKey: defaultCategory
		$I->createEntity("simpleProduct", "hook", "_defaultProduct", ["defaultCategory"], []); // stepKey: simpleProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("defaultCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"MAGETWO-91511: Top destinations cannot be removed after a selection was previously saved"})
	 * @Features({"Checkout"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CheckoutSpecificDestinationsTest(AcceptanceTester $I)
	{
		$I->comment("Go to configuration general page");
		$I->comment("Entering Action Group [navigateToConfigurationGeneralPage] NavigateToConfigurationGeneralPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: navigateToConfigGeneralPageNavigateToConfigurationGeneralPage
		$I->waitForPageLoad(30); // stepKey: waitForConfigPageLoadNavigateToConfigurationGeneralPage
		$I->comment("Exiting Action Group [navigateToConfigurationGeneralPage] NavigateToConfigurationGeneralPageActionGroup");
		$I->comment("Open country options section");
		$I->conditionalClick("#general_country-head", "#general_country-head.open", false); // stepKey: clickOnStoreInformation
		$I->comment("Select top destinations country");
		$I->comment("Entering Action Group [selectTopDestinationsCountry] SelectTopDestinationsCountryActionGroup");
		$I->selectOption("#general_country_destinations", ["Bahamas"]); // stepKey: selectTopDestinationsCountrySelectTopDestinationsCountry
		$I->click("#save"); // stepKey: saveConfigSelectTopDestinationsCountry
		$I->waitForPageLoad(30); // stepKey: waitForSavingConfigSelectTopDestinationsCountry
		$I->comment("Exiting Action Group [selectTopDestinationsCountry] SelectTopDestinationsCountryActionGroup");
		$I->comment("Go to product page");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Add product to cart");
		$I->comment("Entering Action Group [addToCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCart
		$I->comment("Exiting Action Group [addToCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->comment("Go to shopping cart");
		$I->comment("Entering Action Group [amOnPageShoppingCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageAmOnPageShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedAmOnPageShoppingCart
		$I->comment("Exiting Action Group [amOnPageShoppingCart] StorefrontCartPageOpenActionGroup");
		$I->comment("Verify country options in checkout top destination section");
		$I->comment("Entering Action Group [verifyTopDestinationsCountry] VerifyTopDestinationsCountryActionGroup");
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: openShippingDetailsVerifyTopDestinationsCountry
		$I->waitForPageLoad(10); // stepKey: openShippingDetailsVerifyTopDestinationsCountryWaitForPageLoad
		$I->see("Bahamas", "select[name='country_id'] > option:nth-child(2)"); // stepKey: seeCountryVerifyTopDestinationsCountry
		$I->waitForPageLoad(10); // stepKey: seeCountryVerifyTopDestinationsCountryWaitForPageLoad
		$I->comment("Exiting Action Group [verifyTopDestinationsCountry] VerifyTopDestinationsCountryActionGroup");
		$I->comment("Go to configuration general page");
		$I->comment("Entering Action Group [navigateToConfigurationGeneralPage2] NavigateToConfigurationGeneralPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: navigateToConfigGeneralPageNavigateToConfigurationGeneralPage2
		$I->waitForPageLoad(30); // stepKey: waitForConfigPageLoadNavigateToConfigurationGeneralPage2
		$I->comment("Exiting Action Group [navigateToConfigurationGeneralPage2] NavigateToConfigurationGeneralPageActionGroup");
		$I->comment("Open country options section");
		$I->conditionalClick("#general_country-head", "#general_country-head.open", false); // stepKey: clickOnStoreInformation2
		$I->comment("Deselect top destinations country");
		$I->comment("Entering Action Group [unSelectTopDestinationsCountry] UnSelectTopDestinationsCountryActionGroup");
		$I->unselectOption("#general_country_destinations", ["Bahamas"]); // stepKey: unSelectTopDestinationsCountryUnSelectTopDestinationsCountry
		$I->click("#save"); // stepKey: saveConfigUnSelectTopDestinationsCountry
		$I->waitForPageLoad(30); // stepKey: waitForSavingConfigUnSelectTopDestinationsCountry
		$I->comment("Exiting Action Group [unSelectTopDestinationsCountry] UnSelectTopDestinationsCountryActionGroup");
		$I->comment("Go to shopping cart");
		$I->comment("Entering Action Group [amOnPageShoppingCart2] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageAmOnPageShoppingCart2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedAmOnPageShoppingCart2
		$I->comment("Exiting Action Group [amOnPageShoppingCart2] StorefrontCartPageOpenActionGroup");
		$I->comment("Verify country options is shown by default");
		$I->comment("Entering Action Group [verifyTopDestinationsCountry2] VerifyTopDestinationsCountryActionGroup");
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: openShippingDetailsVerifyTopDestinationsCountry2
		$I->waitForPageLoad(10); // stepKey: openShippingDetailsVerifyTopDestinationsCountry2WaitForPageLoad
		$I->see("Afghanistan", "select[name='country_id'] > option:nth-child(2)"); // stepKey: seeCountryVerifyTopDestinationsCountry2
		$I->waitForPageLoad(10); // stepKey: seeCountryVerifyTopDestinationsCountry2WaitForPageLoad
		$I->comment("Exiting Action Group [verifyTopDestinationsCountry2] VerifyTopDestinationsCountryActionGroup");
	}
}
