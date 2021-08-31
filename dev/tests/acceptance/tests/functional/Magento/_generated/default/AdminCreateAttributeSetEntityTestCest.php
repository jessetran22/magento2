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
 * @Title("MC-10884: Create attribute set with new product attribute")
 * @Description("Admin should be able to create attribute set with new product attribute<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateAttributeSetEntityTest.xml<br>")
 * @TestCaseId("MC-10884")
 * @group mtf_migrated
 */
class AdminCreateAttributeSetEntityTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createProductAttribute", "hook", "productAttributeWysiwyg", [], []); // stepKey: createProductAttribute
		$I->createEntity("createAttributeSet", "hook", "CatalogAttributeSet", [], []); // stepKey: createAttributeSet
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->deleteEntity("createAttributeSet", "hook"); // stepKey: deleteAttributeSet
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
	 * @Stories({"Create Attribute Set"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateAttributeSetEntityTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSets
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Entering Action Group [filterProductAttributeSetGridByLabel] GoToAttributeSetByNameActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: clickResetButtonFilterProductAttributeSetGridByLabel
		$I->waitForPageLoad(30); // stepKey: clickResetButtonFilterProductAttributeSetGridByLabelWaitForPageLoad
		$I->fillField("#setGrid_filter_set_name", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: filterByNameFilterProductAttributeSetGridByLabel
		$I->click("#container button[title='Search']"); // stepKey: clickSearchFilterProductAttributeSetGridByLabel
		$I->waitForPageLoad(30); // stepKey: clickSearchFilterProductAttributeSetGridByLabelWaitForPageLoad
		$I->click("#setGrid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRowFilterProductAttributeSetGridByLabel
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFilterProductAttributeSetGridByLabel
		$I->comment("Exiting Action Group [filterProductAttributeSetGridByLabel] GoToAttributeSetByNameActionGroup");
		$I->comment("Assert created attribute in an unassigned attributes");
		$I->see($I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test'), "#tree-div2"); // stepKey: seeAttributeInUnassignedAttr
		$I->comment("Assign attribute in the group");
		$I->comment("Entering Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='" . $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test') . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttributeToGroup
		$I->see($I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttributeToGroup
		$I->comment("Exiting Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->see($I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: seeAttributeInGroup
		$I->comment("Entering Action Group [SaveAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSet
		$I->comment("Exiting Action Group [SaveAttributeSet] SaveAttributeSetActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSets2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->comment("Assert an attribute in the group");
		$I->comment("Entering Action Group [filterProductAttributeSetGridByLabel2] GoToAttributeSetByNameActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: clickResetButtonFilterProductAttributeSetGridByLabel2
		$I->waitForPageLoad(30); // stepKey: clickResetButtonFilterProductAttributeSetGridByLabel2WaitForPageLoad
		$I->fillField("#setGrid_filter_set_name", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: filterByNameFilterProductAttributeSetGridByLabel2
		$I->click("#container button[title='Search']"); // stepKey: clickSearchFilterProductAttributeSetGridByLabel2
		$I->waitForPageLoad(30); // stepKey: clickSearchFilterProductAttributeSetGridByLabel2WaitForPageLoad
		$I->click("#setGrid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRowFilterProductAttributeSetGridByLabel2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFilterProductAttributeSetGridByLabel2
		$I->comment("Exiting Action Group [filterProductAttributeSetGridByLabel2] GoToAttributeSetByNameActionGroup");
		$I->see($I->retrieveEntityField('createProductAttribute', 'attribute_code', 'test'), "#tree-div1"); // stepKey: seeAttributeInGroup2
		$I->comment("Assert attribute can be used in product creation");
		$I->comment("Entering Action Group [navigateToCatalogProductGrid] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToCatalogProductGrid
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToCatalogProductGrid
		$I->comment("Exiting Action Group [navigateToCatalogProductGrid] AdminOpenProductIndexPageActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownClickAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownClickAddSimpleProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductClickAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadClickAddSimpleProduct
		$I->comment("Exiting Action Group [clickAddSimpleProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->comment("Switch from default attribute set to new attribute set");
		$I->comment("Entering Action Group [startEditAttrSet] AdminSelectAttributeSetOnEditProductPageActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: clickAttributeSetDropdownStartEditAttrSet
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", $I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test')); // stepKey: searchForAttributeSetStartEditAttrSet
		$I->waitForPageLoad(30); // stepKey: searchForAttributeSetStartEditAttrSetWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: selectAttributeSetStartEditAttrSet
		$I->waitForPageLoad(30); // stepKey: selectAttributeSetStartEditAttrSetWaitForPageLoad
		$I->comment("Exiting Action Group [startEditAttrSet] AdminSelectAttributeSetOnEditProductPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("See new attribute set");
		$I->see($I->retrieveEntityField('createAttributeSet', 'attribute_set_name', 'test'), "div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: seeAttributeSetName
	}
}
