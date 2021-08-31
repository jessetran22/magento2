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
 * @Title("MC-35612: Preserving attribute value after attribute group is changed")
 * @Description("Attribute value should be preserved after changing attribute group<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminChangeProductAttributeGroupTest.xml<br>")
 * @TestCaseId("MC-35612")
 * @group catalog
 */
class AdminChangeProductAttributeGroupTestCest
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
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->createEntity("createProductAttribute", "hook", "productAttributeText", [], []); // stepKey: createProductAttribute
		$I->createEntity("createAttributeSet", "hook", "CatalogAttributeSet", [], []); // stepKey: createAttributeSet
		$I->createEntity("createSecondAttributeSet", "hook", "CatalogAttributeSet", [], []); // stepKey: createSecondAttributeSet
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/edit/id/" . $I->retrieveEntityField('createAttributeSet', 'attribute_set_id', 'hook') . "/"); // stepKey: onAttributeSetEdit
		$I->comment("Entering Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='" . $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'hook') . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttributeToGroup
		$I->see($I->retrieveEntityField('createProductAttribute', 'attribute_code', 'hook'), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttributeToGroup
		$I->comment("Exiting Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->comment("Entering Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSet
		$I->comment("Exiting Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/edit/id/" . $I->retrieveEntityField('createSecondAttributeSet', 'attribute_set_id', 'hook') . "/"); // stepKey: onSecondAttributeSetEdit
		$I->comment("Entering Action Group [assignAttributeToContentGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Content']", "//*[@id='tree-div1']//span[text()='Content']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttributeToContentGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttributeToContentGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='" . $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'hook') . "']", "//*[@id='tree-div1']//span[text()='Content']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttributeToContentGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttributeToContentGroup
		$I->see($I->retrieveEntityField('createProductAttribute', 'attribute_code', 'hook'), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttributeToContentGroup
		$I->comment("Exiting Action Group [assignAttributeToContentGroup] AssignAttributeToGroupActionGroup");
		$I->comment("Entering Action Group [saveSecondAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveSecondAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveSecondAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveSecondAttributeSet
		$I->comment("Exiting Action Group [saveSecondAttributeSet] SaveAttributeSetActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->deleteEntity("createAttributeSet", "hook"); // stepKey: deleteAttributeSet
		$I->deleteEntity("createSecondAttributeSet", "hook"); // stepKey: deleteSecondAttributeSet
		$I->comment("Entering Action Group [clearProductsFilter] ClearProductsFilterActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexClearProductsFilter
		$I->waitForPageLoad(30); // stepKey: waitForProductsPageToLoadClearProductsFilter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetClearProductsFilter
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetClearProductsFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsFilter] ClearProductsFilterActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Preserving attribute value after attribute group is changed"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminChangeProductAttributeGroupTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct1
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct1
		$I->comment("Exiting Action Group [openEditProduct1] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [selectAttributeSet] AdminProductPageSelectAttributeSetActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: openDropdownSelectAttributeSet
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: filterSelectAttributeSet
		$I->waitForPageLoad(30); // stepKey: filterSelectAttributeSetWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: clickResultSelectAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickResultSelectAttributeSetWaitForPageLoad
		$I->comment("Exiting Action Group [selectAttributeSet] AdminProductPageSelectAttributeSetActionGroup");
		$I->waitForText($I->retrieveEntityField('createProductAttribute', 'default_frontend_label', 'test'), 30); // stepKey: seeAttributeInForm
		$I->fillField("//input[contains(@name, 'product[" . $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test') . "]')]", "test"); // stepKey: fillProductAttributeValue
		$I->comment("Entering Action Group [selectSecondAttributeSet] AdminProductPageSelectAttributeSetActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: openDropdownSelectSecondAttributeSet
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", $I->retrieveEntityField('createSecondAttributeSet', 'attribute_set_name', 'test')); // stepKey: filterSelectSecondAttributeSet
		$I->waitForPageLoad(30); // stepKey: filterSelectSecondAttributeSetWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: clickResultSelectSecondAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickResultSelectSecondAttributeSetWaitForPageLoad
		$I->comment("Exiting Action Group [selectSecondAttributeSet] AdminProductPageSelectAttributeSetActionGroup");
		$I->comment("Entering Action Group [expandContentSection] ExpandAdminProductSectionActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageExpandContentSection
		$I->waitForElementVisible("div[data-index='content']", 30); // stepKey: waitForSectionExpandContentSection
		$I->waitForPageLoad(30); // stepKey: waitForSectionExpandContentSectionWaitForPageLoad
		$I->conditionalClick("div[data-index='content']", "div[data-index='content']._show", false); // stepKey: expandSectionExpandContentSection
		$I->waitForPageLoad(30); // stepKey: expandSectionExpandContentSectionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSectionToExpandExpandContentSection
		$I->comment("Exiting Action Group [expandContentSection] ExpandAdminProductSectionActionGroup");
		$I->waitForText($I->retrieveEntityField('createProductAttribute', 'default_frontend_label', 'test'), 30); // stepKey: seeAttributeInSection
		$attributeValue = $I->grabValueFrom("input[name='product[" . $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test') . "]']"); // stepKey: attributeValue
		$I->assertEquals("test", $attributeValue); // stepKey: assertAttributeValue
	}
}
