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
 * @Title("MC-42006: Product price is updated according to tier prices when changing product quantity")
 * @Description("Check that price of product will be updated according to tier prices on product page when changing product quantity<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StoreFrontAssertProductFinalPriceChangesDynamicallyOnProductPageWithTierPricesConfiguredTest.xml<br>")
 * @TestCaseId("MC-42006")
 * @group catalog
 */
class StoreFrontAssertProductFinalPriceChangesDynamicallyOnProductPageWithTierPricesConfiguredTestCest
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
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->createEntity("createCustomer", "hook", "CustomerEntityOne", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [loginToAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdmin
		$I->comment("Exiting Action Group [loginToAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearFilterProduct] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilterProduct
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterProductWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilterProduct] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Tier price"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontAssertProductFinalPriceChangesDynamicallyOnProductPageWithTierPricesConfiguredTest(AcceptanceTester $I)
	{
		$I->comment("AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [openProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProduct', 'id', 'test')); // stepKey: goToProductOpenProductForEdit
		$I->comment("Exiting Action Group [openProductForEdit] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [addCustomerGroupPrice] AdminAddAdvancedPricingToTheProductActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddCustomerGroupPrice
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkAddCustomerGroupPrice
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkAddCustomerGroupPriceWaitForPageLoad
		$I->click("//span[text()='Add']/ancestor::button"); // stepKey: clickCustomerGroupPriceAddButtonAddCustomerGroupPrice
		$I->waitForPageLoad(30); // stepKey: clickCustomerGroupPriceAddButtonAddCustomerGroupPriceWaitForPageLoad
		$I->selectOption("[name='product[tier_price][0][website_id]']", "0"); // stepKey: selectProductTierPriceWebsiteInputAddCustomerGroupPrice
		$I->selectOption("[name='product[tier_price][0][cust_group]']", "ALL GROUPS"); // stepKey: selectProductTierPriceCustomerGroupInputAddCustomerGroupPrice
		$I->fillField("[name='product[tier_price][0][price_qty]']", "1"); // stepKey: fillProductTierPriceQuantityInputAddCustomerGroupPrice
		$I->fillField("[name='product[tier_price][0][price]']", "90.00"); // stepKey: selectProductTierPriceFixedPriceAddCustomerGroupPrice
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonAddCustomerGroupPrice
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonAddCustomerGroupPriceWaitForPageLoad
		$I->comment("Exiting Action Group [addCustomerGroupPrice] AdminAddAdvancedPricingToTheProductActionGroup");
		$I->comment("Entering Action Group [addCustomerGroupPrice2] AdminAddAdvancedPricingToTheProductActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddCustomerGroupPrice2
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkAddCustomerGroupPrice2
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkAddCustomerGroupPrice2WaitForPageLoad
		$I->click("//span[text()='Add']/ancestor::button"); // stepKey: clickCustomerGroupPriceAddButtonAddCustomerGroupPrice2
		$I->waitForPageLoad(30); // stepKey: clickCustomerGroupPriceAddButtonAddCustomerGroupPrice2WaitForPageLoad
		$I->selectOption("[name='product[tier_price][1][website_id]']", "0"); // stepKey: selectProductTierPriceWebsiteInputAddCustomerGroupPrice2
		$I->selectOption("[name='product[tier_price][1][cust_group]']", "ALL GROUPS"); // stepKey: selectProductTierPriceCustomerGroupInputAddCustomerGroupPrice2
		$I->fillField("[name='product[tier_price][1][price_qty]']", "2"); // stepKey: fillProductTierPriceQuantityInputAddCustomerGroupPrice2
		$I->fillField("[name='product[tier_price][1][price]']", "80"); // stepKey: selectProductTierPriceFixedPriceAddCustomerGroupPrice2
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonAddCustomerGroupPrice2
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonAddCustomerGroupPrice2WaitForPageLoad
		$I->comment("Exiting Action Group [addCustomerGroupPrice2] AdminAddAdvancedPricingToTheProductActionGroup");
		$I->comment("Entering Action Group [addCustomerGroupPrice3] AdminAddAdvancedPricingToTheProductActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddCustomerGroupPrice3
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkAddCustomerGroupPrice3
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkAddCustomerGroupPrice3WaitForPageLoad
		$I->click("//span[text()='Add']/ancestor::button"); // stepKey: clickCustomerGroupPriceAddButtonAddCustomerGroupPrice3
		$I->waitForPageLoad(30); // stepKey: clickCustomerGroupPriceAddButtonAddCustomerGroupPrice3WaitForPageLoad
		$I->selectOption("[name='product[tier_price][2][website_id]']", "0"); // stepKey: selectProductTierPriceWebsiteInputAddCustomerGroupPrice3
		$I->selectOption("[name='product[tier_price][2][cust_group]']", "General"); // stepKey: selectProductTierPriceCustomerGroupInputAddCustomerGroupPrice3
		$I->fillField("[name='product[tier_price][2][price_qty]']", "3"); // stepKey: fillProductTierPriceQuantityInputAddCustomerGroupPrice3
		$I->fillField("[name='product[tier_price][2][price]']", "70"); // stepKey: selectProductTierPriceFixedPriceAddCustomerGroupPrice3
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonAddCustomerGroupPrice3
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonAddCustomerGroupPrice3WaitForPageLoad
		$I->comment("Exiting Action Group [addCustomerGroupPrice3] AdminAddAdvancedPricingToTheProductActionGroup");
		$I->comment("Entering Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSimpleProduct
		$I->comment("Exiting Action Group [saveSimpleProduct] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->fillField("#qty", "2"); // stepKey: fillQuantity
		$I->comment("Entering Action Group [seeSimpleProductPriceOnStoreFrontPage] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see("80", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeSimpleProductPriceOnStoreFrontPage
		$I->comment("Exiting Action Group [seeSimpleProductPriceOnStoreFrontPage] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->fillField("#qty", "3"); // stepKey: fillQuantity2
		$I->comment("Entering Action Group [seeSimpleProductPriceOnStoreFrontPage2] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see("80", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeSimpleProductPriceOnStoreFrontPage2
		$I->comment("Exiting Action Group [seeSimpleProductPriceOnStoreFrontPage2] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [openSimpleProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenSimpleProductPage
		$I->comment("Exiting Action Group [openSimpleProductPage] StorefrontOpenProductPageActionGroup");
		$I->fillField("#qty", "2"); // stepKey: fillQuantity3
		$I->comment("Entering Action Group [seeSimpleProductPriceOnStoreFrontPage3] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see("80", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeSimpleProductPriceOnStoreFrontPage3
		$I->comment("Exiting Action Group [seeSimpleProductPriceOnStoreFrontPage3] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->fillField("#qty", "3"); // stepKey: fillQuantity4
		$I->comment("Entering Action Group [seeSimpleProductPriceOnStoreFrontPage4] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see("70", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeSimpleProductPriceOnStoreFrontPage4
		$I->comment("Exiting Action Group [seeSimpleProductPriceOnStoreFrontPage4] StorefrontAssertProductPriceOnProductPageActionGroup");
	}
}
