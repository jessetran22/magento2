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
 * @Title("MC-40455: Admin can configure a customer wishlist item")
 * @Description("Admin should be able to configure items from customer wishlist<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/AdminConfigureCustomerWishListItemTest.xml<br>")
 * @TestCaseId("MC-40455")
 * @group wishlist
 */
class AdminConfigureCustomerWishListItemTestCest
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
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create the configurable product based on the data in the /data folder");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProductWithOutCategory", [], []); // stepKey: createConfigProduct
		$I->comment("Make the configurable product have two options, that are children of the default attribute set");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$reindexBrokenIndices = $I->magentoCron("index", 90); // stepKey: reindexBrokenIndices
		$I->comment($reindexBrokenIndices);
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
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("Entering Action Group [logout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogout
		$I->comment("Exiting Action Group [logout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$reindexBrokenIndices = $I->magentoCron("index", 90); // stepKey: reindexBrokenIndices
		$I->comment($reindexBrokenIndices);
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
	 * @Features({"Wishlist"})
	 * @Stories({"Wishlist item configuration"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigureCustomerWishListItemTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [addToWishlistProduct] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: WaitForWishListAddToWishlistProduct
		$I->click("a.action.towishlist"); // stepKey: addProductToWishlistClickAddToWishlistAddToWishlistProduct
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addProductToWishlistWaitForSuccessMessageAddToWishlistProduct
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test') . " has been added to your Wish List. Click here to continue shopping.", "div.message-success.success.message"); // stepKey: addProductToWishlistSeeProductNameAddedToWishlistAddToWishlistProduct
		$I->seeCurrentUrlMatches("~/wishlist_id/\d+/$~"); // stepKey: seeCurrentUrlMatchesAddToWishlistProduct
		$I->comment("Exiting Action Group [addToWishlistProduct] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->comment("Entering Action Group [navigateToCustomerEditPage] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersNavigateToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCustomerEditPage
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersNavigateToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersNavigateToCustomerEditPageWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterNavigateToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: openFilterNavigateToCustomerEditPageWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToCustomerEditPage
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterNavigateToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: applyFilterNavigateToCustomerEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCustomerEditPage
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditNavigateToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: clickEditNavigateToCustomerEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCustomerEditPage
		$I->comment("Exiting Action Group [navigateToCustomerEditPage] OpenEditCustomerFromAdminActionGroup");
		$I->comment("Entering Action Group [navigateToWishlistTab] AdminNavigateCustomerWishlistTabActionGroup");
		$I->click("#tab_wishlist_content"); // stepKey: clickWishlistButtonNavigateToWishlistTab
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToWishlistTab
		$I->comment("Exiting Action Group [navigateToWishlistTab] AdminNavigateCustomerWishlistTabActionGroup");
		$I->comment("Entering Action Group [editItem] AdminCustomerWishlistConfigureItemActionGroup");
		$I->click("//table[@id='wishlistGrid_table']//tbody//td[@data-column='product_name' and contains(text(),'" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]/parent::tr//td[@data-column='action']//a[@class='configure-item-link']"); // stepKey: clickConfigureButtonEditItem
		$I->waitForPageLoad(30); // stepKey: clickConfigureButtonEditItemWaitForPageLoad
		$I->waitForElementVisible("//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]/following::div[contains(@class,'control')]//select", 30); // stepKey: waitForConfigurableOptionEditItem
		$I->selectOption("//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]/following::div[contains(@class,'control')]//select", $I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test')); // stepKey: selectConfigurableOptionEditItem
		$I->fillField("#product_composite_configure_input_qty", "2"); // stepKey: fillQtyEditItem
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: confirmSaveEditItem
		$I->waitForPageLoad(30); // stepKey: confirmSaveEditItemWaitForPageLoad
		$I->comment("Exiting Action Group [editItem] AdminCustomerWishlistConfigureItemActionGroup");
		$I->click("#save"); // stepKey: saveCustomer
		$I->waitForPageLoad(30); // stepKey: saveCustomerWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessage
		$I->seeElement("#messages div.message-success"); // stepKey: assertSuccessMessage
		$I->comment("Entering Action Group [navigateToCustomerEditPage2] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersNavigateToCustomerEditPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCustomerEditPage2
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersNavigateToCustomerEditPage2
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersNavigateToCustomerEditPage2WaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterNavigateToCustomerEditPage2
		$I->waitForPageLoad(30); // stepKey: openFilterNavigateToCustomerEditPage2WaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToCustomerEditPage2
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterNavigateToCustomerEditPage2
		$I->waitForPageLoad(30); // stepKey: applyFilterNavigateToCustomerEditPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCustomerEditPage2
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditNavigateToCustomerEditPage2
		$I->waitForPageLoad(30); // stepKey: clickEditNavigateToCustomerEditPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCustomerEditPage2
		$I->comment("Exiting Action Group [navigateToCustomerEditPage2] OpenEditCustomerFromAdminActionGroup");
		$I->comment("Entering Action Group [navigateToWishlistTabAgain] AdminNavigateCustomerWishlistTabActionGroup");
		$I->click("#tab_wishlist_content"); // stepKey: clickWishlistButtonNavigateToWishlistTabAgain
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToWishlistTabAgain
		$I->comment("Exiting Action Group [navigateToWishlistTabAgain] AdminNavigateCustomerWishlistTabActionGroup");
		$I->waitForElementVisible("table#wishlistGrid_table td.col-number[data-column=qty]", 30); // stepKey: waitForProductQuantityVisible
		$I->see("2", "table#wishlistGrid_table td.col-number[data-column=qty]"); // stepKey: assertProductQuantity
	}
}
