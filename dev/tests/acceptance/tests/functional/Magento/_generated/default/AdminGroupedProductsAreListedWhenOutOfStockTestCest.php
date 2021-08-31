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
 * @Title("MAGETWO-93181: Products in group should show in admin list even when they are out of stock")
 * @Description("Products in group should show in admin list even when they are out of stock<h3>Test files</h3>app/code/Magento/GroupedProduct/Test/Mftf/Test/AdminGroupedProductsListTest.xml<br>")
 * @TestCaseId("MAGETWO-93181")
 * @group GroupedProduct
 */
class AdminGroupedProductsAreListedWhenOutOfStockTestCest
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
		$I->createEntity("category1", "hook", "SimpleSubCategory", [], []); // stepKey: category1
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct", ["category1"], []); // stepKey: simpleProduct1
		$I->comment("Out of Stock");
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct4", ["category1"], []); // stepKey: simpleProduct2
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
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("category1", "hook"); // stepKey: deleteCategory
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
	 * @Features({"GroupedProduct"})
	 * @Stories({"MAGETWO-93181: Grouped product doesn't take care about his Linked Products when SalableQuantity < ProductLink.ExtensionAttributes.Qty after Source Deduction"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminGroupedProductsAreListedWhenOutOfStockTest(AcceptanceTester $I)
	{
		$I->comment("Create product");
		$I->comment("Entering Action Group [adminProductIndexPageAdd] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAdminProductIndexPageAdd
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAdminProductIndexPageAdd
		$I->comment("Exiting Action Group [adminProductIndexPageAdd] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateProductPage] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateProductPage
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateProductPageWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-grouped']", 30); // stepKey: waitForAddProductDropdownGoToCreateProductPage
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-grouped']"); // stepKey: clickAddProductTypeGoToCreateProductPage
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateProductPage
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/grouped/"); // stepKey: seeNewProductUrlGoToCreateProductPage
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateProductPage
		$I->comment("Exiting Action Group [goToCreateProductPage] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillMainProductForm] FillGroupedProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "GroupedProduct" . msq("GroupedProduct")); // stepKey: fillProductSkuFillMainProductForm
		$I->fillField(".admin__field[data-index=sku] input", "groupedproduct" . msq("GroupedProduct")); // stepKey: fillProductNameFillMainProductForm
		$I->comment("Exiting Action Group [fillMainProductForm] FillGroupedProductFormActionGroup");
		$I->comment("Add two simple products to grouped product");
		$I->scrollTo("div[data-index=grouped] .admin__collapsible-title", 0, -100); // stepKey: scrollToSection
		$I->conditionalClick("div[data-index=grouped] .admin__collapsible-title", "button[data-index='grouped_products_button']", false); // stepKey: openGroupedProductSection
		$I->waitForPageLoad(30); // stepKey: openGroupedProductSectionWaitForPageLoad
		$I->click("button[data-index='grouped_products_button']"); // stepKey: clickAddProductsToGroup
		$I->waitForPageLoad(30); // stepKey: clickAddProductsToGroupWaitForPageLoad
		$I->waitForElementVisible(".product_form_product_form_grouped_grouped_products_modal [data-action='grid-filter-expand']", 30); // stepKey: waitForFilter
		$I->waitForPageLoad(30); // stepKey: waitForFilterWaitForPageLoad
		$I->comment("Entering Action Group [filterProductGridBySku1] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridBySku1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridBySku1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridBySku1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySku1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku1
		$I->comment("Exiting Action Group [filterProductGridBySku1] FilterProductGridBySkuActionGroup");
		$I->checkOption("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: checkOption1
		$I->comment("Entering Action Group [filterProductGridBySku2] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridBySku2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridBySku2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridBySku2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGridBySku2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridBySku2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridBySku2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridBySku2
		$I->comment("Exiting Action Group [filterProductGridBySku2] FilterProductGridBySkuActionGroup");
		$I->checkOption("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: checkOption2
		$I->click(".product_form_product_form_grouped_grouped_products_modal button.action-primary"); // stepKey: addSelectedProducts
		$I->waitForPageLoad(30); // stepKey: addSelectedProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Save product");
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
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->scrollTo("div[data-index=grouped] .admin__collapsible-title", 0, -100); // stepKey: scrollToProducts
		$I->waitForText($I->retrieveEntityField('simpleProduct1', 'name', 'test'), 30); // stepKey: assertProductIsInTheList
		$I->waitForText($I->retrieveEntityField('simpleProduct2', 'name', 'test'), 30); // stepKey: assertProduct2IsInTheList
	}
}
