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
 * @Title("MC-39950: Create Grouped Product when non-default attribute set is chosen")
 * @Description("Create Grouped Product with simple when non-default attribute set is chosen<h3>Test files</h3>app/code/Magento/GroupedProduct/Test/Mftf/Test/AdminCreateGroupedProductNonDefaultAttributeSetTest.xml<br>")
 * @TestCaseId("MC-39950")
 * @group groupedProduct
 */
class AdminCreateGroupedProductNonDefaultAttributeSetTestCest
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
		$I->createEntity("createSimpleProduct", "hook", "ApiProductWithDescription", [], []); // stepKey: createSimpleProduct
		$I->createEntity("createAttributeSet", "hook", "CatalogAttributeSet", [], []); // stepKey: createAttributeSet
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
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createAttributeSet", "hook"); // stepKey: deleteAttributeSet
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
	 * @Stories({"Create product"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateGroupedProductNonDefaultAttributeSetTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [createGroupedProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexCreateGroupedProduct
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownCreateGroupedProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownCreateGroupedProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-grouped']"); // stepKey: clickAddProductCreateGroupedProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadCreateGroupedProduct
		$I->comment("Exiting Action Group [createGroupedProduct] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("Entering Action Group [selectAttributeSet] AdminProductPageSelectAttributeSetActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: openDropdownSelectAttributeSet
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: filterSelectAttributeSet
		$I->waitForPageLoad(30); // stepKey: filterSelectAttributeSetWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: clickResultSelectAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickResultSelectAttributeSetWaitForPageLoad
		$I->comment("Exiting Action Group [selectAttributeSet] AdminProductPageSelectAttributeSetActionGroup");
		$I->comment("Entering Action Group [fillProductForm] FillGroupedProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "GroupedProduct" . msq("GroupedProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "groupedproduct" . msq("GroupedProduct")); // stepKey: fillProductNameFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillGroupedProductFormActionGroup");
		$I->comment("Entering Action Group [addSimpleToGroup] AdminAssignProductToGroupActionGroup");
		$I->scrollTo("div[data-index=grouped] .admin__collapsible-title", 0, -100); // stepKey: scrollToGroupedSectionAddSimpleToGroup
		$I->conditionalClick("div[data-index=grouped] .admin__collapsible-title", "button[data-index='grouped_products_button']", false); // stepKey: openGroupedProductsSectionAddSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: openGroupedProductsSectionAddSimpleToGroupWaitForPageLoad
		$I->click("button[data-index='grouped_products_button']"); // stepKey: clickAddProductsToGroupAddSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: clickAddProductsToGroupAddSimpleToGroupWaitForPageLoad
		$I->conditionalClick(".product_form_product_form_grouped_grouped_products_modal [data-action='grid-filter-reset']", ".product_form_product_form_grouped_grouped_products_modal [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersAddSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersAddSimpleToGroupWaitForPageLoad
		$I->click(".product_form_product_form_grouped_grouped_products_modal [data-action='grid-filter-expand']"); // stepKey: showFiltersPanelAddSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: showFiltersPanelAddSimpleToGroupWaitForPageLoad
		$I->fillField(".product_form_product_form_grouped_grouped_products_modal [name='name']", $I->retrieveEntityField('createSimpleProduct', 'name', 'test')); // stepKey: fillNameFilterAddSimpleToGroup
		$I->click(".product_form_product_form_grouped_grouped_products_modal [data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddSimpleToGroupWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: selectProductAddSimpleToGroup
		$I->click(".product_form_product_form_grouped_grouped_products_modal button.action-primary"); // stepKey: clickAddSelectedGroupProductsAddSimpleToGroup
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedGroupProductsAddSimpleToGroupWaitForPageLoad
		$I->comment("Exiting Action Group [addSimpleToGroup] AdminAssignProductToGroupActionGroup");
		$I->comment("Entering Action Group [assertProductOptionGrid] AdminAssertProductOnGroupedOptionGridActionGroup");
		$grabProductNameAssertProductOptionGrid = $I->grabTextFrom(".data-row td[data-index='name']"); // stepKey: grabProductNameAssertProductOptionGrid
		$I->assertEquals($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), $grabProductNameAssertProductOptionGrid); // stepKey: assertProductNameAssertProductOptionGrid
		$grabProductSkuAssertProductOptionGrid = $I->grabTextFrom(".data-row td[data-index='sku']"); // stepKey: grabProductSkuAssertProductOptionGrid
		$I->assertEquals($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), $grabProductSkuAssertProductOptionGrid); // stepKey: assertProductSkuAssertProductOptionGrid
		$I->comment("Exiting Action Group [assertProductOptionGrid] AdminAssertProductOnGroupedOptionGridActionGroup");
	}
}
