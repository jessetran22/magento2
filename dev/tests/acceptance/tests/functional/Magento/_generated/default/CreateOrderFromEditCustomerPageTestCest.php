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
 * @group Sales
 * @group mtf_migrated
 * @Title("MC-16161: Create order from edit customer page and add products to wish list and shopping cart")
 * @Description("Create an order from edit customer page and add products to the wish list and shopping cart<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/CreateOrderFromEditCustomerPageTest.xml<br>")
 * @TestCaseId("MC-16161")
 */
class CreateOrderFromEditCustomerPageTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("freeShippingMethodsSettingConfig", "hook", "FreeShippingMethodsSettingConfig", [], []); // stepKey: freeShippingMethodsSettingConfig
		$I->comment("Create simple customer");
		$I->createEntity("simpleCustomer", "hook", "Simple_US_Customer_CA", [], []); // stepKey: simpleCustomer
		$I->comment("Create Simple Product");
		$simpleProductFields['price'] = "10.00";
		$I->createEntity("simpleProduct", "hook", "SimpleProduct2", [], $simpleProductFields); // stepKey: simpleProduct
		$simpleProduct1Fields['price'] = "20.00";
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], $simpleProduct1Fields); // stepKey: simpleProduct1
		$I->comment("Create configurable product and add it to the category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create an attribute with two options to be used in the first child product");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->comment("Add the attribute we just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Get the option of the attribute we created");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->comment("Create a simple product and give it the attribute with option");
		$createConfigChildProduct1Fields['price'] = "30.00";
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], $createConfigChildProduct1Fields); // stepKey: createConfigChildProduct1
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigProductOption
		$I->comment("Add simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->createEntity("disableFreeShippingConfig", "hook", "DisableFreeShippingConfig", [], []); // stepKey: disableFreeShippingConfig
		$I->deleteEntity("simpleCustomer", "hook"); // stepKey: deleteSimpleCustomer
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigurableProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [openCustomerIndexPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageOpenCustomerIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomerIndexPage
		$I->comment("Exiting Action Group [openCustomerIndexPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Entering Action Group [clearCustomerGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearCustomerGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearCustomerGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearCustomerGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Create Order"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CreateOrderFromEditCustomerPageTest(AcceptanceTester $I)
	{
		$I->comment("Filter and Open the customer edit page");
		$I->comment("Entering Action Group [filterTheCustomer] AdminFilterCustomerByEmail");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomerIndexPageFilterTheCustomer
		$I->waitForPageLoad(30); // stepKey: waitToCustomerIndexPageToLoadFilterTheCustomer
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerIndexPageFilterTheCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerIndexPageFilterTheCustomerWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterTheCustomer
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterTheCustomerWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('simpleCustomer', 'email', 'test')); // stepKey: filterEmailFilterTheCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterFilterTheCustomer
		$I->waitForPageLoad(30); // stepKey: applyFilterFilterTheCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFilterTheCustomer
		$I->comment("Exiting Action Group [filterTheCustomer] AdminFilterCustomerByEmail");
		$I->click("//tr[@class='data-row' and //div[text()='" . $I->retrieveEntityField('simpleCustomer', 'email', 'test') . "']]//a[@class='action-menu-item']"); // stepKey: clickOnEditButton
		$I->waitForPageLoad(30); // stepKey: clickOnEditButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerEditPageToLoad
		$I->click("#order"); // stepKey: clickOnCreateOrderButton
		$I->waitForPageLoad(30); // stepKey: clickOnCreateOrderButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoad
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppears
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsWaitForPageLoad
		$I->comment("Add configurable product to order");
		$I->comment("Entering Action Group [addConfigurableProductToOrder] AddConfigurableProductToOrderFromAdminActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageAddConfigurableProductToOrder
		$I->waitForElementVisible("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']", 30); // stepKey: waitForAddProductsButtonAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: waitForAddProductsButtonAddConfigurableProductToOrderWaitForPageLoad
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddConfigurableProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createConfigProduct', 'sku', 'test')); // stepKey: fillSkuFilterConfigurableAddConfigurableProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchConfigurableAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchConfigurableAddConfigurableProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddConfigurableProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectConfigurableProductAddConfigurableProductToOrder
		$I->waitForElementVisible("//div[contains(@class,'product-options')]//select[//label[text() = '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']]", 30); // stepKey: waitForConfigurablePopoverAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: waitForConfigurablePopoverAddConfigurableProductToOrderWaitForPageLoad
		$I->wait(2); // stepKey: waitForOptionsToLoadAddConfigurableProductToOrder
		$I->selectOption("//div[contains(@class,'product-options')]//select[//label[text() = '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']]", $I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test')); // stepKey: selectionConfigurableOptionAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: selectionConfigurableOptionAddConfigurableProductToOrderWaitForPageLoad
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: clickOkConfigurablePopoverAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickOkConfigurablePopoverAddConfigurableProductToOrderWaitForPageLoad
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddConfigurableProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddConfigurableProductToOrderWaitForPageLoad
		$I->comment("Exiting Action Group [addConfigurableProductToOrder] AddConfigurableProductToOrderFromAdminActionGroup");
		$I->comment("Add Simple product to order");
		$I->comment("Entering Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSimpleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddSimpleProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSimpleProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSimpleProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSimpleProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddSimpleProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSimpleProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSimpleProductToOrder
		$I->comment("Exiting Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Add Second Simple product to order");
		$I->comment("Entering Action Group [addSecondSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSecondSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSecondSimpleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillSkuFilterAddSecondSimpleProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSecondSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSecondSimpleProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSecondSimpleProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSecondSimpleProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddSecondSimpleProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSecondSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSecondSimpleProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSecondSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSecondSimpleProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSecondSimpleProductToOrder
		$I->comment("Exiting Action Group [addSecondSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Move Products to the WishList");
		$I->selectOption("//td[contains(.,'" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "')]/../..//td//select", "Move to Wish List"); // stepKey: moveProductToWishList
		$I->selectOption("//td[contains(.,'" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]/../..//td//select", "Move to Wish List"); // stepKey: moveConfigurableProductToWishList
		$I->click("//span[text()='Update Items and Quantities']"); // stepKey: clickOnUpdateItemsAndQuantity
		$I->waitForPageLoad(30); // stepKey: waitForAdminCreateOrderWishListSectionPageLoad
		$I->comment("Assert products in Wish List  section");
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), "#sidebar_data_wishlist"); // stepKey: seeSimpleProductInWishList
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), "#sidebar_data_wishlist"); // stepKey: seeConfigurableProductInWishList
		$I->comment("Move products to order from Wish List");
		$I->waitForElementVisible("//div[@id='order-sidebar_wishlist']//tr[td[.='" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "']]//input[contains(@name,'sidebar[add_wishlist_item]')]", 30); // stepKey: waitForCheckBoxToVisible
		$I->waitForPageLoad(30); // stepKey: waitForCheckBoxToVisibleWaitForPageLoad
		$I->click("//div[@id='order-sidebar_wishlist']//tr[td[.='" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "']]//input[contains(@name,'sidebar[add_wishlist_item]')]"); // stepKey: selectProductToAddToOrder
		$I->waitForPageLoad(30); // stepKey: selectProductToAddToOrderWaitForPageLoad
		$I->click(".order-sidebar .actions .action-default.scalable"); // stepKey: clickUpdateChangesButton
		$I->waitForPageLoad(30); // stepKey: clickUpdateChangesButtonWaitForPageLoad
		$I->click("//div[@id='order-sidebar_wishlist']//tr[td[contains(.,'" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//a[contains(@class, 'icon-configure')]"); // stepKey: AddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: AddConfigurableProductToOrderWaitForPageLoad
		$I->waitForElementVisible("//div[contains(@class,'product-options')]//select[//label[text() = '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']]", 30); // stepKey: waitForConfigurablePopover
		$I->waitForPageLoad(30); // stepKey: waitForConfigurablePopoverWaitForPageLoad
		$I->selectOption("//div[contains(@class,'product-options')]//select[//label[text() = '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']]", $I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test')); // stepKey: selectConfigurableOption
		$I->waitForPageLoad(30); // stepKey: selectConfigurableOptionWaitForPageLoad
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: clickOkButton
		$I->waitForPageLoad(30); // stepKey: clickOkButtonWaitForPageLoad
		$I->comment("Action should be removed but replaced with comment due to backward compatibility");
		$I->waitForPageLoad(30); // stepKey: waitForAdminOrderItemsOrderedSectionPageLoad1
		$I->comment("Assert Products in Order item section");
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), "#order-items_grid  span[id*=order_item]"); // stepKey: seeSimpleProductInOrderItemGrid
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), "#order-items_grid  span[id*=order_item]"); // stepKey: seeConfigProductInOrderItemGrid
		$I->comment("Move Products to the Shopping Cart");
		$I->selectOption("//td[contains(.,'" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "')]/../..//td//select", "Move to Shopping Cart"); // stepKey: moveFirstSimpleProductToShoppingCart
		$I->selectOption("//td[contains(.,'" . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . "')]/../..//td//select", "Move to Shopping Cart"); // stepKey: moveSecondSimpleProductToShoppingCart
		$I->click("//span[text()='Update Items and Quantities']"); // stepKey: clickOnUpdateItems
		$I->waitForPageLoad(30); // stepKey: waitForAdminCreateOrderShoppingCartSectionPageLoad
		$I->comment("Assert products in Shopping cart section");
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), "#sidebar_data_cart"); // stepKey: seeProductInShoppingCart
		$I->see($I->retrieveEntityField('simpleProduct1', 'name', 'test'), "#sidebar_data_cart"); // stepKey: seeSecondProductInShoppingCart
		$I->comment("Move products to the order from shopping cart");
		$I->waitForElementVisible("//div[@id='order-sidebar_cart']//tr[td[.='" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "']]//input[contains(@name,'sidebar[add_cart_item]')]", 30); // stepKey: waitForAddToOrderCheckBox
		$I->waitForPageLoad(30); // stepKey: waitForAddToOrderCheckBoxWaitForPageLoad
		$I->click("//div[@id='order-sidebar_cart']//tr[td[.='" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "']]//input[contains(@name,'sidebar[add_cart_item]')]"); // stepKey: selectFirstProduct
		$I->waitForPageLoad(30); // stepKey: selectFirstProductWaitForPageLoad
		$I->click("//div[@id='order-sidebar_cart']//tr[td[.='" . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . "']]//input[contains(@name,'sidebar[add_cart_item]')]"); // stepKey: selectSecondProduct
		$I->waitForPageLoad(30); // stepKey: selectSecondProductWaitForPageLoad
		$I->click(".order-sidebar .actions .action-default.scalable"); // stepKey: clickOnUpdateButton1
		$I->waitForPageLoad(30); // stepKey: clickOnUpdateButton1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminCreateOrderShoppingCartSectionPageLoad1
		$I->comment("After move, assert products are not present in Shopping cart section");
		$I->dontSee($I->retrieveEntityField('simpleProduct', 'name', 'test'), "#sidebar_data_cart"); // stepKey: donSeeProductInShoppingCart
		$I->dontSee($I->retrieveEntityField('simpleProduct1', 'name', 'test'), "#sidebar_data_cart"); // stepKey: dontSeeSecondProductInShoppingCart
		$I->comment("After move, assert products are not present in Wish List section");
		$I->dontSee($I->retrieveEntityField('simpleProduct', 'name', 'test'), "#sidebar_data_wishlist"); // stepKey: seeSimpleProductInWishList1
		$I->dontSee($I->retrieveEntityField('createConfigProduct', 'name', 'test'), "#sidebar_data_wishlist"); // stepKey: seeConfigurableProductInWishList1
		$I->comment("After move, assert products are present in order items section");
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), "#order-items_grid  span[id*=order_item]"); // stepKey: seeSimpleProductInOrderItemGrid1
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), "#order-items_grid  span[id*=order_item]"); // stepKey: seeConfigProductInOrderItemGrid1
		$I->see($I->retrieveEntityField('simpleProduct1', 'name', 'test'), "#order-items_grid  span[id*=order_item]"); // stepKey: seeSecondProductInOrderItemGrid1
		$I->comment("Select Free Shipping");
		$I->waitForElementVisible("//span[text()='Get shipping methods and rates']", 30); // stepKey: waitForShippingSection
		$I->waitForPageLoad(60); // stepKey: waitForShippingSectionWaitForPageLoad
		$I->comment("Entering Action Group [openShippingMethod] AdminClickGetShippingMethodsAndRatesActionGroup");
		$I->click("//span[text()='Get shipping methods and rates']"); // stepKey: openShippingMethodOpenShippingMethod
		$I->waitForPageLoad(60); // stepKey: openShippingMethodOpenShippingMethodWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsOpenShippingMethod
		$I->comment("Exiting Action Group [openShippingMethod] AdminClickGetShippingMethodsAndRatesActionGroup");
		$I->comment("Adding the comment to replace action for preserving Backward Compatibility");
		$I->click("#s_method_freeshipping_freeshipping"); // stepKey: chooseShippingMethod
		$I->waitForPageLoad(30); // stepKey: chooseShippingMethodWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Entering Action Group [submitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderSubmitOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Verify order information");
		$I->comment("Entering Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$I->see("You created the order.", "div.message-success"); // stepKey: seeSuccessMessageVerifyCreatedOrderInformation
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderPendingStatusVerifyCreatedOrderInformation
		$getOrderIdVerifyCreatedOrderInformation = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderIdVerifyCreatedOrderInformation
		$I->assertNotEmpty($getOrderIdVerifyCreatedOrderInformation); // stepKey: assertOrderIdIsNotEmptyVerifyCreatedOrderInformation
		$I->comment("Exiting Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$orderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: orderId
		$I->comment("Filter and Open the customer edit page");
		$I->comment("Entering Action Group [filterTheCustomer1] AdminFilterCustomerByEmail");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomerIndexPageFilterTheCustomer1
		$I->waitForPageLoad(30); // stepKey: waitToCustomerIndexPageToLoadFilterTheCustomer1
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerIndexPageFilterTheCustomer1
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerIndexPageFilterTheCustomer1WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterTheCustomer1
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterTheCustomer1WaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('simpleCustomer', 'email', 'test')); // stepKey: filterEmailFilterTheCustomer1
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterFilterTheCustomer1
		$I->waitForPageLoad(30); // stepKey: applyFilterFilterTheCustomer1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFilterTheCustomer1
		$I->comment("Exiting Action Group [filterTheCustomer1] AdminFilterCustomerByEmail");
		$I->click("//tr[@class='data-row' and //div[text()='" . $I->retrieveEntityField('simpleCustomer', 'email', 'test') . "']]//a[@class='action-menu-item']"); // stepKey: clickOnEditButton1
		$I->waitForPageLoad(30); // stepKey: clickOnEditButton1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerEditPageToLoad1
		$I->click("#tab_orders_content"); // stepKey: clickOnOrdersButton
		$I->waitForPageLoad(30); // stepKey: clickOnOrdersButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToOpen
		$I->click("//td[contains(., '$orderId')]"); // stepKey: selectOnOrderID
		$I->comment("Assert ordered product in customer order section");
		$I->waitForPageLoad(30); // stepKey: waitForOrderInformationToLoad
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".edit-order-table .col-product .product-title"); // stepKey: seeConfigurableProductInGrid
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".edit-order-table .col-product .product-title"); // stepKey: seeFirstProductInGrid
		$I->see($I->retrieveEntityField('simpleProduct1', 'name', 'test'), ".edit-order-table .col-product .product-title"); // stepKey: seeSecondProductInGrid
		$I->see("Ordered", ".edit-order-table .col-status"); // stepKey: seeProductStatus
		$I->see($I->retrieveEntityField('createConfigChildProduct1', 'price', 'test'), ".edit-order-table .col-subtotal .price"); // stepKey: seeConfigurableProductSubtotal
		$I->see($I->retrieveEntityField('simpleProduct', 'price', 'test'), ".edit-order-table .col-subtotal .price"); // stepKey: seeFirstProductSubtotal
		$I->see($I->retrieveEntityField('simpleProduct1', 'price', 'test'), ".edit-order-table .col-subtotal .price"); // stepKey: seeSecondProductSubtotal
		$I->see("60.00", ".order-subtotal-table tbody tr.col-0>td span.price"); // stepKey: checkSubtotal
		$I->see("0.00", "//table[contains(@class, 'order-subtotal-table')]//td[normalize-space(.)='Shipping & Handling']/following-sibling::td//span[@class='price']"); // stepKey: checkShippingAndHandling
		$I->see("60.00", ".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: checkGrandTotal
	}
}
