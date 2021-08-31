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
 * @Title("MC-10828: Create product attribute of type Multiple Select and check its visibility on frontend in Advanced Search form")
 * @Description("Admin should be able to create product attribute of type Multiple Select and check its visibility on frontend in Advanced Search form<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateMultipleSelectProductAttributeVisibleInStorefrontAdvancedSearchFormTest.xml<br>")
 * @TestCaseId("MC-10828")
 * @group mtf_migrated
 */
class AdminCreateMultipleSelectProductAttributeVisibleInStorefrontAdvancedSearchFormTestCest
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
		$I->comment("Create a multiple select product attribute with two options");
		$I->createEntity("attribute", "hook", "productAttributeMultiselectTwoOptionsNotSearchable", [], []); // stepKey: attribute
		$I->createEntity("option1", "hook", "productAttributeOption1", ["attribute"], []); // stepKey: option1
		$I->createEntity("option2", "hook", "productAttributeOption2", ["attribute"], []); // stepKey: option2
		$I->comment("Create product attribute set");
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
		$I->comment("Delete product attribute");
		$I->deleteEntity("attribute", "hook"); // stepKey: deleteProductAttribute
		$I->comment("Delete product attribute set");
		$I->deleteEntity("createAttributeSet", "hook"); // stepKey: deleteAttributeSet
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
	 * @Features({"Catalog"})
	 * @Stories({"Create Multiple Select product attribute and check its visibility in Advanced Search form"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateMultipleSelectProductAttributeVisibleInStorefrontAdvancedSearchFormTest(AcceptanceTester $I)
	{
		$I->comment("Filter product attribute set by attribute set name");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: amOnAttributeSetPage
		$I->comment("Entering Action Group [filterProductAttrSetGridByAttrSetName] FilterProductAttributeSetGridByAttributeSetNameActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: clickResetButtonFilterProductAttrSetGridByAttrSetName
		$I->waitForPageLoad(30); // stepKey: clickResetButtonFilterProductAttrSetGridByAttrSetNameWaitForPageLoad
		$I->fillField("#setGrid_filter_set_name", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: filterByNameFilterProductAttrSetGridByAttrSetName
		$I->click("#container button[title='Search']"); // stepKey: clickSearchFilterProductAttrSetGridByAttrSetName
		$I->waitForPageLoad(30); // stepKey: clickSearchFilterProductAttrSetGridByAttrSetNameWaitForPageLoad
		$I->click("#setGrid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRowFilterProductAttrSetGridByAttrSetName
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1FilterProductAttrSetGridByAttrSetName
		$I->comment("Exiting Action Group [filterProductAttrSetGridByAttrSetName] FilterProductAttributeSetGridByAttributeSetNameActionGroup");
		$I->comment("Assert created attribute in an unassigned attributes");
		$I->see($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div2"); // stepKey: seeAttributeInUnassignedAttr
		$I->comment("Assign attribute in the group");
		$I->comment("Entering Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='" . $I->retrieveEntityField('attribute', 'attribute_code', 'test') . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttributeToGroup
		$I->see($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttributeToGroup
		$I->comment("Exiting Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->see($I->retrieveEntityField('attribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: seeAttributeInGroup
		$I->comment("Entering Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSet
		$I->comment("Exiting Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->comment("Go to Product Attribute Grid page");
		$I->comment("Entering Action Group [navigateToProductAttributeGrid] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageNavigateToProductAttributeGrid
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadNavigateToProductAttributeGrid
		$I->comment("Exiting Action Group [navigateToProductAttributeGrid] AdminOpenProductAttributePageActionGroup");
		$I->fillField("#attributeGrid_filter_attribute_code", $I->retrieveEntityField('attribute', 'attribute_code', 'test')); // stepKey: fillAttrCodeField
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickSearchBtn
		$I->waitForPageLoad(30); // stepKey: clickSearchBtnWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: chooseFirstRow
		$I->waitForPageLoad(30); // stepKey: chooseFirstRowWaitForPageLoad
		$I->comment("Change attribute property: Frontend Label");
		$I->fillField("#attribute_label", "attribute" . msq("productDropDownAttribute")); // stepKey: fillDefaultLabel
		$I->comment("Change attribute property: Use in Search >Yes");
		$I->scrollToTopOfPage(); // stepKey: scrollToTabs
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTab
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->selectOption("#is_searchable", "Yes"); // stepKey: seeInSearch
		$I->comment("Change attribute property: Visible In Advanced Search >No");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->selectOption("#is_visible_in_advanced_search", "No"); // stepKey: dontSeeInAdvancedSearch
		$I->comment("Save the new product attributes");
		$I->click("#save"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSuccessMessage
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Go to store's advanced catalog search page");
		$I->comment("Entering Action Group [GoToStoreViewAdvancedCatalogSearchActionGroup] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->amOnPage("/catalogsearch/advanced/"); // stepKey: GoToStoreViewAdvancedCatalogSearchActionGroupGoToStoreViewAdvancedCatalogSearchActionGroup
		$I->waitForPageLoad(90); // stepKey: waitForPageLoadGoToStoreViewAdvancedCatalogSearchActionGroup
		$I->comment("Exiting Action Group [GoToStoreViewAdvancedCatalogSearchActionGroup] GoToStoreViewAdvancedCatalogSearchActionGroup");
		$I->dontSeeElement("#" . $I->retrieveEntityField('attribute', 'attribute_code', 'test')); // stepKey: dontSeeAttribute
	}
}
