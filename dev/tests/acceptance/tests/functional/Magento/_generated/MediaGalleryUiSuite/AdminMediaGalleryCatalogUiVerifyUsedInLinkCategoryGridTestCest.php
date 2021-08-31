<?php
namespace Magento\AcceptanceTest\_MediaGalleryUiSuite\Backend;

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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4523889: DEPRECATED. User can open each entity the asset is associated with in a separate tab to manage association")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4523889")
 * @Description("User can open each entity the asset is associated with in a separate tab to manage association<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use AdminMediaGalleryCatalogUiVerifyUsedInLinkCategoryGridTest instead</li></ul><h3>Test files</h3>app/code/Magento/MediaGalleryCatalogUi/Test/Mftf/Test/AdminMediaGalleryCatalogUiVerifyUsedInLinkCategoryGridTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryCatalogUiVerifyUsedInLinkCategoryGridTestCest
{
	/**
	 * @Features({"MediaGalleryCatalogUi"})
	 * @Stories({"Story 58: User sees entities where asset is used in"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryCatalogUiVerifyUsedInLinkCategoryGridTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse AdminMediaGalleryCatalogUiVerifyUsedInLinkCategoryGridTest instead");
	}
}
