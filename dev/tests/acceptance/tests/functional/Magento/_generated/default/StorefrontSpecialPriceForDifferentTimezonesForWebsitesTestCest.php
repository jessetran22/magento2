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
 * @Title("MAGETWO-97508: Check that special price displayed when 'default config' scope timezone does not match 'website' scope timezone")
 * @Description("Check that special price displayed when 'default config' scope timezone does not match 'website' scope timezone<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontSpecialPriceForDifferentTimezonesForWebsitesTest.xml<br>")
 * @TestCaseId("MAGETWO-97508")
 * @group Catalog
 */
class StorefrontSpecialPriceForDifferentTimezonesForWebsitesTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete create data");
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
	 * @Features({"Catalog"})
	 * @Stories({"Special price"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontSpecialPriceForDifferentTimezonesForWebsitesTest(AcceptanceTester $I)
	{
		$I->comment("Set timezone for default config");
		$I->comment("Entering Action Group [goToGeneralConfig] AdminOpenGeneralConfigurationPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: openGeneralConfigurationPageGoToGeneralConfig
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToGeneralConfig
		$I->comment("Exiting Action Group [goToGeneralConfig] AdminOpenGeneralConfigurationPageActionGroup");
		$I->conditionalClick("#general_locale-head", "#general_locale_timezone", false); // stepKey: openLocaleSection
		$originalTimezone = $I->grabValueFrom("#general_locale_timezone"); // stepKey: originalTimezone
		$I->selectOption("#general_locale_timezone", "Central European Standard Time (Europe/Paris)"); // stepKey: setTimezone
		$I->click("#save"); // stepKey: saveConfig
		$I->waitForPageLoad(30); // stepKey: saveConfigWaitForPageLoad
		$I->comment("Set timezone for Main Website");
		$I->comment("Entering Action Group [goToGeneralConfig1] AdminOpenGeneralConfigurationPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: openGeneralConfigurationPageGoToGeneralConfig1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToGeneralConfig1
		$I->comment("Exiting Action Group [goToGeneralConfig1] AdminOpenGeneralConfigurationPageActionGroup");
		$I->comment("Entering Action Group [AdminSwitchStoreViewActionGroup] AdminSwitchWebsiteActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopAdminSwitchStoreViewActionGroup
		$I->click("#store-change-button"); // stepKey: clickWebsiteSwitchDropdownAdminSwitchStoreViewActionGroup
		$I->waitForElementVisible("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]", 30); // stepKey: waitForWebsiteAreVisibleAdminSwitchStoreViewActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleAdminSwitchStoreViewActionGroupWaitForPageLoad
		$I->click("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]"); // stepKey: clickWebsiteByNameAdminSwitchStoreViewActionGroup
		$I->waitForPageLoad(30); // stepKey: clickWebsiteByNameAdminSwitchStoreViewActionGroupWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchStoreViewActionGroup
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchStoreViewActionGroupWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchStoreViewActionGroup
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchStoreViewActionGroupWaitForPageLoad
		$I->see("Main Website", ".store-switcher"); // stepKey: seeNewWebsiteNameAdminSwitchStoreViewActionGroup
		$I->comment("Exiting Action Group [AdminSwitchStoreViewActionGroup] AdminSwitchWebsiteActionGroup");
		$I->conditionalClick("#general_locale-head", "#general_locale_timezone", false); // stepKey: openLocaleSection1
		$I->uncheckOption("#general_locale_timezone_inherit"); // stepKey: uncheckUseDefault
		$originalTimezone1 = $I->grabValueFrom("#general_locale_timezone"); // stepKey: originalTimezone1
		$I->selectOption("#general_locale_timezone", "Greenwich Mean Time (Africa/Abidjan)"); // stepKey: setTimezone1
		$I->click("#save"); // stepKey: saveConfig1
		$I->waitForPageLoad(30); // stepKey: saveConfig1WaitForPageLoad
		$I->comment("Set special price to created product");
		$I->comment("Entering Action Group [openAdminEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductOpenAdminEditPage
		$I->comment("Exiting Action Group [openAdminEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [setSpecialPriceToCreatedProduct] AddSpecialPriceToProductActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSetSpecialPriceToCreatedProduct
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkSetSpecialPriceToCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkSetSpecialPriceToCreatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalSetSpecialPriceToCreatedProduct
		$I->waitForElementVisible("input[name='product[special_price]']", 30); // stepKey: waitSpecialPriceSetSpecialPriceToCreatedProduct
		$I->fillField("input[name='product[special_price]']", "15"); // stepKey: fillSpecialPriceSetSpecialPriceToCreatedProduct
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneSetSpecialPriceToCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneSetSpecialPriceToCreatedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalGoneSetSpecialPriceToCreatedProduct
		$I->waitForElementNotVisible("input[name='product[special_price]']", 30); // stepKey: waitForCloseModalWindowSetSpecialPriceToCreatedProduct
		$I->comment("Exiting Action Group [setSpecialPriceToCreatedProduct] AddSpecialPriceToProductActionGroup");
		$I->comment("Entering Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->comment("Login to storefront from customer and check price");
		$I->comment("Entering Action Group [logInFromCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLogInFromCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLogInFromCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLogInFromCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLogInFromCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLogInFromCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLogInFromCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLogInFromCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLogInFromCustomer
		$I->comment("Exiting Action Group [logInFromCustomer] LoginToStorefrontActionGroup");
		$I->comment("Go to the product page and check special price");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$grabSpecialPrice = $I->grabTextFrom("//span[@class='special-price']//span[@class='price']"); // stepKey: grabSpecialPrice
		$I->assertEquals("$15.00", $grabSpecialPrice); // stepKey: assertSpecialPrice
		$I->comment("Reset timezone");
		$I->comment("Entering Action Group [goToGeneralConfigReset] AdminOpenGeneralConfigurationPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: openGeneralConfigurationPageGoToGeneralConfigReset
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToGeneralConfigReset
		$I->comment("Exiting Action Group [goToGeneralConfigReset] AdminOpenGeneralConfigurationPageActionGroup");
		$I->conditionalClick("#general_locale-head", "#general_locale_timezone", false); // stepKey: openLocaleSectionReset
		$I->selectOption("#general_locale_timezone", "$originalTimezone"); // stepKey: resetTimezone
		$I->click("#save"); // stepKey: saveConfigReset
		$I->waitForPageLoad(30); // stepKey: saveConfigResetWaitForPageLoad
		$I->comment("Reset timezone");
		$I->comment("Entering Action Group [goToGeneralConfigReset1] AdminOpenGeneralConfigurationPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: openGeneralConfigurationPageGoToGeneralConfigReset1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToGeneralConfigReset1
		$I->comment("Exiting Action Group [goToGeneralConfigReset1] AdminOpenGeneralConfigurationPageActionGroup");
		$I->comment("Entering Action Group [AdminSwitchStoreViewActionGroup1] AdminSwitchWebsiteActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopAdminSwitchStoreViewActionGroup1
		$I->click("#store-change-button"); // stepKey: clickWebsiteSwitchDropdownAdminSwitchStoreViewActionGroup1
		$I->waitForElementVisible("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]", 30); // stepKey: waitForWebsiteAreVisibleAdminSwitchStoreViewActionGroup1
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleAdminSwitchStoreViewActionGroup1WaitForPageLoad
		$I->click("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]"); // stepKey: clickWebsiteByNameAdminSwitchStoreViewActionGroup1
		$I->waitForPageLoad(30); // stepKey: clickWebsiteByNameAdminSwitchStoreViewActionGroup1WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchStoreViewActionGroup1
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchStoreViewActionGroup1WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchStoreViewActionGroup1
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchStoreViewActionGroup1WaitForPageLoad
		$I->see("Main Website", ".store-switcher"); // stepKey: seeNewWebsiteNameAdminSwitchStoreViewActionGroup1
		$I->comment("Exiting Action Group [AdminSwitchStoreViewActionGroup1] AdminSwitchWebsiteActionGroup");
		$I->conditionalClick("#general_locale-head", "#general_locale_timezone", false); // stepKey: openLocaleSectionReset1
		$I->uncheckOption("#general_locale_timezone_inherit"); // stepKey: uncheckUseDefault1
		$I->selectOption("#general_locale_timezone", "$originalTimezone"); // stepKey: resetTimezone1
		$I->click("#save"); // stepKey: saveConfigReset1
		$I->waitForPageLoad(30); // stepKey: saveConfigReset1WaitForPageLoad
	}
}
